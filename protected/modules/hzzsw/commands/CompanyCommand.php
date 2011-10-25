<?php
$apiPath = Yii::import('webroot.api');
include $apiPath.'/simple_html_dom.php';
class CompanyCommand extends CConsoleCommand
{
	public function actionTest()
	{
		$this->fetchCompanyB('http://www.77883.com/company/index.asp?id=602', '', '');
	}
	
	public function actionCompanySearch()
	{
		$locations = array('上城区', '下城区', '西湖区', '拱墅区', '江干区', '滨江区', '余杭区', '萧山区', '其他区');
		$categoires = array('家装公司', '监理单位', '设计单位', '施工单位', '材料厂商', '供应商店');
		
		$insert = array();
		foreach ($categoires as $category) {
			
			$insert['category'] = $category;
			
			foreach ($locations as $location) {
				
				$insert['location'] = $location;
				
				$preUrl = 'http://www.77883.com/CompanyShow/index.asp?key=&xingzhi='.rawurlencode(mb_convert_encoding($category, 'GBK', 'UTF-8')).'&diqu='.rawurlencode(mb_convert_encoding($location, 'GBK', 'UTF-8'));
				$str = Yii::app()->fetch->readUrl($preUrl);
				preg_match('/<strong><font color=red>\d+<\/font>\/(\d+)<\/strong>页/isU', $str, $match);
				$numPage = $match[1];
				$i  = 0;
				while ($i++ < $numPage) {
					
					sleep(rand(1,2));
					
					$url = $preUrl.'&page='.$i;
					
					$insert['data_catch_url'] = $url;
					echo $url."\n";
					
					$str = Yii::app()->fetch->readUrl($url);
					$html = str_get_dom($str);
					foreach ($html->find('td[width=384]') as $td) {
						$companyUrl = $td->firstChild()->href;
						if (strpos($companyUrl, '../buy/') === false)	{	//过滤不存在公司链接
							$insert['url'] = 'http://www.77883.com/'.substr($companyUrl, 3);
							Yii::app()->db->createCommand()->insert('77883_company_search', $insert);
						}
					}
				}
			}
		}
	}
	
	public function actionCompany($start,$count)
	{
		$command = $str = Yii::app()->db->createCommand()->from('77883_company_search')->limit($count, $start);
		foreach ($command->queryAll() as $row) {
			
			sleep(rand(0, 1));
			
			echo $row['url']."\n";
			
			if (strpos($row['url'], 'company') === false) {
				$this->fetchCompanyA($row['url'], $row['category'], $row['location']);
			}
			else 
				$this->fetchCompanyB($row['url'], $row['category'], $row['location']);
		}
	}
	
	
	private function fetchCompanyA($companyUrl, $category, $location)
	{
		$company = array();
		
		$company['company_url'] = $companyUrl;
		$company['category'] = $category;
		$company['location'] = $location;
				
		$contactMatch = array(
			'单位名称：' => 'company_name',
			'单位地址：' => 'address',
			'邮政编码：' => 'postcode',
			'联系电话：' => 'telephone',
			'传真号码：' => 'fax',
			'电子邮件：' => 'email',
			'官方网站：' => 'url',
		);
		$titleKeys = array_keys($contactMatch);
		
		$str = Yii::app()->fetch->readUrl($companyUrl);
		$html = str_get_dom($str);
		$company['introduce'] = trim($html->find('.shg', 0)->innertext);
		$html->clear();
		unset($html);
		unset($str);
		
		$contactUrl = str_replace('index.asp', 'index7.asp', $companyUrl);
		$str = Yii::app()->fetch->readUrl($contactUrl);
		$html = str_get_dom($str);
		
		foreach ($html->find('table[cellspacing=3] tr') as $tr) {
			$title = trim($tr->firstChild()->plaintext);
			$content = trim($tr->lastChild()->plaintext);
			if (in_array($title, $titleKeys)) {
				$company[$contactMatch[$title]] = $content;
			}
			else if (strlen($title) == 44) 
				$company['contact_user'] = $content;
		}
		
		try {
			Yii::app()->db->createCommand()->insert('77883_company', $company);
		}
		catch (Exception $e) {
			echo $e->getMessage();
		}
		
		$html->clear();
		unset($html);
		unset($str);
		
	}
	
	private function fetchCompanyB($companyUrl, $category, $location)
	{
		$company = array();
		
		$company['company_url'] = $companyUrl;
		$company['category'] = $category;
		$company['location'] = $location;
		
		$str = Yii::app()->fetch->readUrl($companyUrl);
		$html = str_get_dom($str);
		
		$company['introduce'] = $html->find('td[height=135]', 0)->innertext;
		
		$html->clear();
		unset($html);
		unset($str);
		
		$str = Yii::app()->fetch->readUrl(str_replace('index', 'contact', $companyUrl));
		$html = str_get_dom($str);
		
		$keyMatch = array( 'company_name', 'address', 'postcode','telephone','fax','contact_user','email','url',);
		foreach ($keyMatch as $index => $key) {
			$company[$key] = trim($html->find('.0099line', $index * 3 + 2)->plaintext);
		}
		try {
			Yii::app()->db->createCommand()->insert('77883_company', $company);
		}
		catch (Exception $e) {
			echo $e->getMessage();
		}
		
		$html->clear();
		unset($html);
		unset($str);
		
	}
}