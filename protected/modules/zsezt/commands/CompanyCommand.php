<?php
$apiPath = Yii::import('webroot.api');
include $apiPath.'/simple_html_dom.php';
class CompanyCommand extends CConsoleCommand
{
	public function actionTest()
	{
		$str = Yii::app()->fetch->readUrl('http://www.zsezt.com/xuanren/list-group-7-location-%E6%B5%99%E6%B1%9F');
		var_dump($str);
	}
	public function actionCompany()
	{
		$preUrl = 'http://www.zsezt.com/xuanren/list-group-7-location-%E6%B5%99%E6%B1%9F-page-';
		$totalPage = 14;
		$i = 0;
		while ($i++ < $totalPage) {
			$url = $preUrl.$i.'.html';
			
			echo $url."\n";
			
			$str = Yii::app()->fetch->readUrl($url);
			//var_dump(mb_convert_encoding($str, 'GBK', 'UTF-8'));
			if ($str) {
				$html = str_get_dom($str);
				
				//$length = count($html->find('table tr'));
				$length = 11;
				$j = 0;
				while (++$j < $length) {
					$companyUrl = 'http://www.zsezt.com'.$html->find('table tr', $j)->children(1)->children(0)->children(0)->href;
					$contactUrl = 'http://www.zsezt.com/team/about'.substr($companyUrl, strpos($companyUrl, '-'));
					$this->fetchCompany($contactUrl, $companyUrl);
				}
			
				$html->clear();
				unset($html);
			}
		}
	}
	
	private function fetchCompany($contactUrl, $companyUrl)
	{
		
		sleep(rand(3, 5));
		
		$str = Yii::app()->fetch->readUrl($contactUrl);
		
		echo $contactUrl."\n";
		
		if ($str) {
			$html = str_get_dom($str);
			foreach ($html->find('table[width=695] p') as $domP) {
				$title = $domP->firstChild()->innertext;
				if ($title == '店铺全称：') {
					$company['company_name'] = $domP->lastChild()->innertext;
				}
				
				if ($title == '所属地区：') {
					$company['location'] = substr($domP->plaintext, 15);	
				}
				if ($domP->style == 'padding-left:63px;') {
					$company['introduce'] = $domP->innertext;
				}
				
			}
			
			preg_match('/<p><span style="letter-spacing:6px;">联系<\/span>人：(.*)<br \/>联系电话：(.*)<br \/>(.+)<br \/>联系手机：(.*)<br \/>邮政编码：(.*)<br \/>电子邮件：(.+)<br \/>QQ：.*<br \/>MSN：.*<br \/>联系地址：(.*)<br \/>店铺网址：.*<br \/> <\/p>/isU', $str, $matches);
			$company['contact_user'] = $matches[1];
			$company['telephone'] = $matches[2];
			$company['fax'] = substr($matches[3], 17) === false ? '' : substr($matches[3], 17);
			$company['mobile'] = $matches[4];
			$company['postcode'] = $matches[5];
			$company['email'] = $matches[6];
			$company['address'] = $matches[7];
			$company['data_catch_url'] = $contactUrl;
			$company['company_url'] = $companyUrl;
		
			try {
				Yii::app()->db->createCommand()->insert('zsezt_company', $company);
			}
			catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
}