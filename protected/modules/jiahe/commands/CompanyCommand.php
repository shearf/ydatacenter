<?php
$apiPath = Yii::import('webroot.api');
include $apiPath.'/simple_html_dom.php';

class CompanyCommand extends CConsoleCommand
{
	public function actionTest()
	{
		
	}
	
	public function actionCompany($start, $count)
	{
		
		$preUrl = 'http://z.hangzhou.51hejia.com/companies';
		while ($count-- > 0) {
			$url = $preUrl.'-'.$start++.'/';
			
			echo $url."\n";
			
			$str = Yii::app()->fetch->readUrl($url);
			if ($str) {
				$html = str_get_dom($str);
				foreach ($html->find('.list_r_li_data01') as $li) {
					$companyUrl = $li->firstChild()->href;
					$this->fetchCompany($companyUrl, $url);
				}
				
				$html->clear();
				unset($html);
			}
			unset($str);
		}
			
	}
	
	private function fetchCompany($companyUrl, $catchUrl)
	{
		echo $companyUrl."\n";
		
		$company = array();
		
		$company['company_url'] = $companyUrl;
		$company['data_catch_url'] = $catchUrl;
		
		$str = Yii::app()->fetch->readUrl($companyUrl);
		if ($str) {
			$html = str_get_dom($str);
			
			$company['company_name'] = $html->find('.zxdp2010_info', 0)->firstChild()->innertext;
			$table = $html->find('table[width=288]', 0);
			$company['address'] = trim($table->children(2)->children(1)->plaintext);
			
			$qqInfo = $table->children(3)->lastChild()->innertext;
			$company['email'] = $this->getEmail($qqInfo);
			/*
			if (strpos($qqInfo, '(')) {
				$company['email'] = substr($qqInfo, 3, strpos($qqInfo, '(') + 3).'@qq.com';
			}
			else {
				$company['email'] = substr($qqInfo, 3).'@qq.com';
			}
			*/
			
			$telephone = array();
			foreach ($table->children(4)->find('p') as $p) {
				$telephone[] = trim($p->innertext);
			}
			$company['telephone'] = implode('|', $telephone);
			
			Yii::app()->db->createCommand()->insert('51jiahe_company', $company);
			
			$p->clear();
			unset($p);
			$table->clear();
			$html->clear();
			unset($table);
			unset($html);
		}
	}
	
	private function getEmail($qqInfo)
	{
		return $qqInfo;
	}
}
?>