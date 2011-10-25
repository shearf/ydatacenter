<?php
class CompanyCommand extends CConsoleCommand
{
	
	public function init()
	{
		
	}
	
	public function actionSearchResult()
	{
		$objCompany = new AlibabaCompany();
		$strDocPath = Yii::getPathOfAlias('application.doc')."/";
		$data = new Spreadsheet_Excel_Reader($strDocPath.'公司目录整理.xls');
		$i = 1;
		while ($i++ < $data->rowcount(0)) {
			if (empty($data->sheets[0]['cells'][$i][4])) {
				continue;
			}
			else {
				if (strpos($data->sheets[0]['cells'][$i][4], 'http://search.china.alibaba.com') !== false) {
					$objCompany->getSearchList($data->sheets[0]['cells'][$i][4], $data->sheets[0]['cells'][$i][5]);
					//CCommonFunction::sleepWhile(0, 5);
				}
			}
		}
		foreach ($data->sheets[0]['cells'] as $arrCells) {
		}
		Yii::app()->end();
	}
	
	public function actionGetSearchPage()
	{
		$objCompany = new AlibabaCompany();
		$objCompany->getSearchListPage();
	}
	
	public function actionGetCompanyUrl($intCount=array())
	{
		$objCompany = new AlibabaCompany();
		if ($intCount)
			$objCompany->getCompanyUrl($objCompany->getSubCompanyId($intCount));
		else
			$objCompany->getCompanyUrl(); 
	}
	
	public function actionGetCompanyContact($intCount)
	{
		$objCompany = new AlibabaCompany();
		$arrId = $objCompany->getSubCompanyIdForContact($intCount);
		$objCompany->getCompanyContact($arrId);
	}
	
	public function actionGetCompanyRegister($start, $count)
	{
		include Yii::getPathOfAlias('webroot').'/api/simple_html_dom.php';
		
		$arrMatchWord = array(
			'地址' => 'address',
			'成立日期' => 'register_date',
			'经营范围' => 'business',
			'注册号' => 'code',
			'法定代表人' => 'legal',
			'企业类型' => 'type',
			'登记机关' => 'registration',
			'部门' => 'department',
			'职位' => 'position',
		);
		$arrUnit = array(
			'人民币' => 1,
			'美元' => 2,
			'港币' => 3,
		);
		$objFetch = new FetchAlibaba();
		foreach (Yii::app()->db->createCommand()->select('company_id')->from('tmp_import_company')->limit($count, $start)->queryAll() as $arrCompanyId) {
			$strCompanyUrl = array_shift(Yii::app()->db->createCommand()->select('company_url')->from('company')->where('company_id='.$arrCompanyId['company_id'])->queryRow());
			preg_match('/http:\/\/([a-zA-z_0-9]+).cn.alibaba.com\//isU', $strCompanyUrl, $match);
			$strUserId = $match[1];
			$strRegisterUrl = $strCompanyUrl.'athena/bizreflist/'.$strUserId.'.html';
			
			$str = $objFetch->readUrl($strRegisterUrl);
			$sleepSec = rand(1,2);
			sleep($sleepSec);
			//echo "read\n";
			
			$html = str_get_html($str);
			foreach ($html->find('dl.info-list') as $html_info_list) {
				foreach ($html_info_list->find('dd.float-clr') as $html_item) {
					$strTitle = str_replace(array('&nbsp;', '：'),'',$html_item->children(0)->plaintext);
					$strContent = trim(strip_tags($html_item->children(1)->plaintext));
					switch ($strTitle) {
						case '注册资本':
							if (preg_match('/(人民币|美元|港币)\s*(\d+)\s*万元/isU', $strContent,$match)){
								$arrFetchData['unit'] = $arrUnit[$match[1]];
								$arrFetchData['capital'] = $match[2];
							}
							else {
								$arrFetchData['unit'] = 1;
								$arrFetchData['capital'] = 0;
							}
							break;
						case '营业期限':
							$arrDate = explode('至', $strContent);
							$arrFetchData['from_date'] = $arrDate[0];
							$arrFetchData['to_date'] = $arrDate[1];
							break;
						case '年检时间':
							$arrFetchData['check_year'] = intval($strContent);
							break;
						case '申请人':
							$arrUser = explode(' ', $strContent);
							$arrFetchData['apply_user'] = trim($arrUser[0]);
							$arrFetchData['gender'] = trim(array_pop($arrUser)) == '先生' ? 1 : 2;
							break;
						default:
							$arrFetchData[$arrMatchWord[$strTitle]] = $strContent;
							break;
					}
				}
			}
			//echo "matched\n";
			try {
				$modelRegister = new CompanyRegister();
				$modelRegister->company_id = $arrCompanyId['company_id'];
				$modelRegister->data_catch_url = $strRegisterUrl;
				$modelRegister->attributes = $arrFetchData;
				if ($modelRegister->validate()) {
					$modelRegister->save();
					//echo "Saved\n";
				}
				else {
					echo $strCompanyUrl."\n";
					echo $strRegisterUrl."\n";
					print_r($modelRegister->getErrors());
					//exit();
				}
			}
			catch (Exception $e) {
				echo $strCompanyUrl."\n";
				echo $strRegisterUrl."\n";
				echo $e->getMessage();
				//exit();
			}
		}
	}
	
	public function actionContactTest()
	{
		$objCompany = new AlibabaCompany();
		$objCompany->getCompanyContact(array(438));
	}
	
	public function actionGetRandCompany($intNum)
	{
		//获得总分类数量
		$command = $this->connDataSrc->createCommand('SELECT DISTINCT category FROM company');
		$intCategoriesNum = $command->query()->count();
		$intCategoryCompanyNum = (int)ceil($intNum / $intCategoriesNum);
		
		foreach ($command->queryAll() as $arrRow) {
			$sql = "SELECT COUNT(com.company_id) AS num FROM company as com,company_contact AS contact, company_info AS info WHERE com.company_id = info.company_id AND com.company_id=contact.company_id AND com.category='".$arrRow['category']."' AND com.url_type = 1";
			$arrNumRow = $this->connDataSrc->createCommand($sql)->queryRow();
			//echo $arrNumRow['num']."\n";
			if ($arrNumRow['num'] < $intCategoryCompanyNum) {
				$arrLimitedCategory[$arrRow['category']] = $arrNumRow['num'];
			}
		}
		/*
		//获得数量不够的分类下的全部公司
		foreach ($arrLimitedCategory as $strCode => $n) {
			$sql = "SELECT com.company_id AS id FROM company as com,company_contact AS contact, company_info AS info WHERE com.company_id = info.company_id AND com.company_id=contact.company_id AND com.category='".$strCode."'";
			foreach ($this->connDataSrc->createCommand($sql)->queryAll() as $arrRow) {
				$this->connDataSrc->createCommand()->insert('tmp_import_company', array('company_id' => $arrRow['id'],'user_id' => 0));
				//$arrCompanyId[] = $arrRow[''];
			}
		}
		*/
		//计算已经取得公司数量
		$intCompanyNumFound = array_sum($arrLimitedCategory);
		//var_dump($intCategoryCompanyNum);exit;
		$intCategoryCompanyNum = (int)ceil(($intNum - $intCompanyNumFound) / ($intCategoriesNum - count($arrLimitedCategory)));
		//var_dump($intCategoryCompanyNum);exit;
		foreach ($command->queryAll() as $arrRow) {
			$sql = "SELECT com.company_id AS id FROM company as com,company_contact AS contact, company_info AS info WHERE com.company_id = info.company_id AND com.company_id=contact.company_id AND com.category='".$arrRow['category']."' AND url_type = 1 ORDER BY rand() LIMIT ".$intCategoryCompanyNum;
			foreach ($this->connDataSrc->createCommand($sql)->queryAll() as $arrRow) { 
				$this->connDataSrc->createCommand()->insert('tmp_import_company', array('company_id' => $arrRow['id'],'user_id' => 0));
			}
		}
		
	}
	
	public function actionUpdateRegister($count)
	{
		include Yii::getPathOfAlias('webroot').'/api/simple_html_dom.php';
		
		$arrMatchWord = array(
			'地址' => 'address',
			//'成立日期' => 'register_date',
			'经营范围' => 'business',
			'注册号' => 'code',
			'法定代表人' => 'legal',
			'企业类型' => 'type',
			'登记机关' => 'registration',
			'部门' => 'department',
			'职位' => 'position',
		);
		$arrUnit = array(
			'人民币' => 1,
			'美元' => 2,
			'港币' => 3,
		);
		$objFetch = new FetchAlibaba();
		$arrId = $this->getUnlockedCompanyId($count);
		foreach ($arrId as $intCompanyId) {
			//var_dump($arrRegisterInfo);exit;
			$arrRegisterInfo = Yii::app()->db->createCommand()->select('data_catch_url')->from('company_register')->where('company_id='.$intCompanyId)->queryRow();
			$str = $objFetch->readUrl($arrRegisterInfo['data_catch_url']);
			$sleepSec = rand(1,2);
			sleep($sleepSec);
			echo "read\n";
			
			$html = str_get_html($str);
			$arrFetchData = array();
			foreach ($html->find('dl.info-list') as $html_info_list) {
				foreach ($html_info_list->find('dd.float-clr') as $html_item) {
					$strTitle = str_replace(array('&nbsp;', '：'),'',$html_item->children(0)->plaintext);
					$strContent = trim(strip_tags($html_item->children(1)->plaintext));
					switch ($strTitle) {
						case '注册资本':
							if (preg_match('/(人民币|美元|港币)\s*(\d+)\s*万元/isU', $strContent,$match)){
								$arrFetchData['unit'] = $arrUnit[$match[1]];
								$arrFetchData['capital'] = $match[2];
							}
							else {
								$arrFetchData['unit'] = 1;
								$arrFetchData['capital'] = 0;
							}
							break;
						case '营业期限':
							$arrDate = explode('至', $strContent);
							$arrFetchData['from_date'] = trim($arrDate[0]);
							$arrFetchData['to_date'] = trim($arrDate[1]);
							break;
						case '年检时间':
							$arrFetchData['check_year'] = intval($strContent);
							break;
						case '申请人':
							$arrUser = explode(' ', $strContent);
							$arrFetchData['apply_user'] = trim($arrUser[0]);
							$arrFetchData['gender'] = trim(array_pop($arrUser)) == '先生' ? 1 : 2;
							break;
							
						case '成立日期':
							//var_dump($strContent);
							if (preg_match('/(\d+)年(\d+)月(\d+)日/isU', $strContent, $match)) {
								//var_dump($match);exit;
								$arrFetchData['register_date'] = implode('-', array($match[1], $match[2], $match[3]));
							}
							break;
						default:
							$arrFetchData[$arrMatchWord[$strTitle]] = $strContent;
							break;
					}
				}
			}
			echo "Matched\n";
//			var_dump($arrFetchData);
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modelRegister = CompanyRegister::loadModel($intCompanyId);
				//$modelRegister->company_id = $arrCompanyId['company_id'];
				$modelRegister->attributes = $arrFetchData;
				//var_dump($modelRegister->attributes);exit;
				$modelRegister->valid = 1;
				$modelRegister->locked = 0;
				if ($modelRegister->validate()) {
					$modelRegister->url_type = 1;
					$modelRegister->save();
					echo "Saved\n";
				}
				else {
					echo $arrRegisterInfo['data_catch_url']."\n";
					$intUrlType = empty($modelRegister->apply_user) ? 0 : 2;
					Yii::app()->db->createCommand()->update('company_register', array('url_type' => $intUrlType), 'company_id='.$intCompanyId);
					print_r($modelRegister->getErrors());
				}
				$transaction->commit();
			}
			catch (Exception $e) {
				echo $arrRegisterInfo['data_catch_url']."\n";
				$transaction->rollback();
				echo $e->getMessage();
				exit();
			}
		}
	}
	
	private function getUnlockedCompanyId($count)
	{
		$arrId = array();
		foreach (Yii::app()->db->createCommand()->select('company_id')->from('company_register')->where('locked = 0 AND valid = 0')->limit($count)->queryAll() as $arrCompanyId) {
			$arrId[] = $arrCompanyId['company_id'];
		}
		try {
			Yii::app()->db->createCommand()->update('company_register', array('locked' => 1), 'company_id IN ('.implode(',', $arrId).')');
		}
		catch (Exception $e) {
			echo $e->getMessage();
		}
		return $arrId;
	}
}
?>
