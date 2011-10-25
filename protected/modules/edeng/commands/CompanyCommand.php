<?php
$apiPath = Yii::import('webroot.api');
include $apiPath.'/simple_html_dom.php';

class CompanyCommand extends CConsoleCommand
{
	/*
	public function actionCompany()
	{
		$url = 'http://hangzhou.edeng.cn/33/zhuangshi/index195.html';
		
		while ($url != '') {
			
			echo $url."\n";
			
			$str = Yii::app()->fetch->readUrl($url);
			$html = str_get_html($str);
			
			$length = count($html->find('.house_img1'));
			
			$i = 0;
			while ($i < $length) {
				try {
					$modelCompany = new Company();
					$modelCompany->logo = '';
					if ($html->find('.house_img1', $i)->firstChild()->tag == 'a') {
						$modelCompany->logo = $modelCompany->logo = $html->find('.house_img1',$i)->firstChild()->firstChild()->src;
					}
					$modelCompany->company_url = $html->find('.houseinfor_title', $i)->firstChild()->firstChild()->href;
					$modelCompany->company_name = $html->find('.houseprice', $i)->innertext;
					
					$modelCompany->location_id = 1;
					$modelCompany->category_id = 1;
					$modelCompany->data_catch_url = $url;
					
					if ($modelCompany->validate()) {
						$modelCompany->save();
					}
					else {
						echo "INDEX:".$i."\n";
						//sleep(1);
						//print_r($modelCompany->getErrors());
						++$i;
						continue;
					}
				}
				catch (Exception $e) {
					//echo $e->getMessage()."\n";
				}
				++$i;
			}
			
			$url = $html->find('.page-next', 0) ? $html->find('.page-next', 0)->href : '';
			$html->clear();
			unset($str);
			unset($html);
		}		
	}
	*/
	public function actionContact($count)
	{
		$command = Yii::app()->db->createCommand()->select('company_id')->from('edeng_company')->where('locked=0 AND valid=0')->limit($count);
		$ids = array();
		foreach ($command->queryAll() as $row) {
			$ids[] = $row['company_id'];
		}
		
		Yii::app()->db->createCommand()->update('edeng_company', array('locked' => 1), 'company_id IN ('.implode(',', $ids).')');
		
		foreach ($ids as $id) {
			$company_url = array_pop(Yii::app()->db->createCommand()->select('company_url')->from('edeng_company')->where('company_id='.$id)->queryRow());
				
			echo $company_url."\n";
			
			$str = Yii::app()->fetch->readUrl($company_url);
			$html = str_get_html($str);
			
			if ($html->find('#404kuan', 0) !== null) 
				continue;
				
			try {
				$modelContact = new CompanyContact();
				$modelContact->company_id = $id;
				$modelContact->contact_user = str_replace('&nbsp;', '', $html->find('.username', 0)->innertext);
				$modelContact->telephone = $html->find('.contactphonefc', 0)->plaintext;
				$email = trim($html->find('.email', 0)->plaintext);
				preg_match('/[a-z0-9_\-\.]+\@[a-z0-9]+[_\-]?\.+[a-z]{2,3}/i', $email, $match);
				$modelContact->email = $match[0];
					
				$address = $html->find('.properties', 0)->lastChild()->plaintext;
				$modelContact->location = substr($address, 15);
				$modelContact->data_catch_url = $company_url;
				
				if ($modelContact->validate()) {
					$modelContact->save();
					
					Yii::app()->db->createCommand()->update('edeng_company', array('valid' => 0, 'locked' => 0), 'company_id='.$id);
				}
				else {
					print_r($modelContact->getErrors());
				}
			}
			catch (Exception $e) {
				echo $e->getMessage()."\n";
			}
			
			$html->clear();
			unset($html);
			unset($str);
		}
		
	}
	
	public function actionLocation()
	{

		$str = Yii::app()->fetch->readUrl('http://www.edeng.cn/13/zhuangshi/');
		$html = str_get_dom($str);
		$i = 0;
		foreach ($html->find('#v2_hotCity a') as $domA) {
			if ($i++ == 0) 
				continue;
			if($domA->innertext != '关闭') {
				Yii::app()->db->createCommand()->insert('edeng_location', array('location' => $domA->innertext, 'has_child' => 1, 'search_url' => $domA->href, 'data_catch_url' => 'http://www.edeng.cn/13/zhuangshi/'));
				$insertId = Yii::app()->db->getLastInsertID();
				var_dump($insertId);
				$this->getChildLocation($domA->href, $insertId);
			}
		}
		$html->clear();
		unset($html);
		unset($str);
		
	}
	
	public function actionCategory()
	{
		
	}
	/**
	 * 
	 * @description 
	 * @params
	 * */
	private function getChildLocation($searchUrl, $parent_id)
	{
		$str = Yii::app()->fetch->readUrl($searchUrl);
		$html = str_get_dom($str);
		$i = 0;
		foreach ($html->find('#v2_hotCity a') as $domA) {
			if ($i++ == 0) 
				continue;
			if($domA->innertext != '关闭')
				Yii::app()->db->createCommand()->insert('edeng_location', array('location' => $domA->innertext, 'parent_id' => $parent_id, 'data_catch_url' => $searchUrl, 'search_url' => $domA->href));
			//$insertId = Yii::app()->db->getLastInsertID();
			//$this->getChildLocation($domA->href, $insertId);
		}
		$html->clear();
		unset($html);
		unset($str);
	}
	
	public function actionSearchUrl()
	{
		$command = Yii::app()->db->createCommand()->select('location_id, search_url')->from('edeng_location')->where('parent_id=87');
		
		foreach ($command->queryAll() as $row) {
			
			$url = $row['search_url'];
			
			echo $url."\n";
			
			while ($url != '') {
				$str = Yii::app()->fetch->readUrl($url);
				$html = str_get_dom($str);
				$length = count($html->find('.house_img1'));
				
				$i = 0;
				while ($i < $length) {
					
					$detail_url = $html->find('.houseinfor_title', $i)->firstChild()->firstChild()->href;
					try {
						Yii::app()->db->createCommand()->insert('edeng_search_url', array('url' => $detail_url, 'category_id' => 0, 'location_id' => $row['location_id'], 'data_catch_url' => $url));
					}
					catch (Exception $e) {
						echo $e->getMessage()."\n";
					}
					
					$url = $html->find('.page-next', 0) ? $html->find('.page-next', 0)->href : '';
					
					$i++;
				}
				
				$html->clear();
				unset($html);
				unset($str);
			}
		
		}
	}
	
	public function actionCompany($count)
	{
		$ids = array();
		foreach (Yii::app()->db->createCommand()->select('url_id')->from('edeng_search_url')->where('locked=0 AND valid=0')->limit($count)->queryAll() as $row) {
			$ids[] = $row['url_id'];
		}
		
		Yii::app()->db->createCommand()->update('edeng_search_url', array('locked' => 1), 'url_id IN ('.implode(',',$ids).')');
		foreach ($ids as $id) {
			$row = Yii::app()->db->createCommand()->from('edeng_search_url')->where('url_id='.$id)->queryRow();
			
			$str = Yii::app()->fetch->readUrl($row['url']);
			
			echo $row['url']."\n";
			
			if ($str) {
				
				$html = str_get_dom($str);
				
				if ($html->find('#404kuan', 0) !== null) {
					Yii::app()->db->createCommand()->update('edeng_search_url', array('valid' => 1, 'locked' => 0), 'url_id='.$id);
					continue;
				}
	
				foreach ($html->find('.properties li') as $li) {
					if ($li->firstChild()->innertext == '公司名称：') {
						$content['company_name'] = substr($li->plaintext, 15);
					}
					else if($li->firstChild()->innertext == '具体位置：') {
						$content['location'] = substr($html->find('.properties', 0)->lastChild()->plaintext, 15);				
					}
				}
				$content['contact_user'] = str_replace('&nbsp;', '', $html->find('.username', 0)->innertext);
				$email = trim($html->find('.email', 0)->plaintext);
				preg_match('/[a-z0-9_\-\.]+\@[a-z0-9]+[_\-]?\.+[a-z]{2,3}/i', $email, $match);
				$content['email'] = $match[0]; 
				$content['introduce'] = $html->find('.edcontent',0)->lastChild()->plaintext;
				$content['mobile'] = $html->find('.contactphonefc', 0)->plaintext;
				$content['data_catch_url'] = $row['url'];
				$content['category_id'] = 0;
				$content['location_id'] = $row['location_id'];
				try {
					Yii::app()->db->createCommand()->insert('edeng_company', $content);
					Yii::app()->db->createCommand()->update('edeng_search_url', array('valid' => 1, 'locked' => 0), 'url_id='.$id);
				}
				catch (Exception $e) {
					if ($e->getCode() == 23000) 
						Yii::app()->db->createCommand()->update('edeng_search_url', array('valid' => 1, 'locked' => 0), 'url_id='.$id);
					else 
						echo $e->getMessage()."\n";
				}
				$html->clear();
				unset($html);
			}
			unset($str);
		}
	}
}
?>
