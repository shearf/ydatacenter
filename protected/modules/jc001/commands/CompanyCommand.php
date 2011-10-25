<?php
$apiPath = Yii::import('webroot.api');
include $apiPath.'/simple_html_dom.php';
class CompanyCommand extends CConsoleCommand
{
	public function actionCategory()
	{
		$str = Yii::app()->fetch->readUrl('http://shop.jc001.cn/');
		$htmlDom = str_get_dom($str);
		$searchUrl = array();
		//var_dump(count($htmlDom->find('#proType li')));exit;
		foreach ($htmlDom->find('.proTypeList ul li') as $liDom) {
			$model = new CompanyCategory();
			$model->category_name = $liDom->firstChild()->firstChild()->plaintext;
			$model->parent_id = 0;
			if ($model->save()) {
				foreach ($liDom->find('p a') as $aDom) {
					$modelChild = new CompanyCategory();
					$modelChild->parent_id = $model->category_id;
					$modelChild->category_name = $aDom->plaintext;
					if ($modelChild->save()) {
						$model->has_child = 1;
						$model->save();
					}
					$searchUrl[$modelChild->category_id] = $aDom->href;
				}
			}
		}
		$fileHandel = fopen(Yii::getPathOfAlias('application.modules.jc001.data').'/category_search_company.txt', 'w');
		fwrite($fileHandel, serialize($searchUrl));
		fclose($fileHandel);
		Yii::app()->end();
		
	}
	
	public function actionTest()
	{
		$str = Yii::app()->fetch->readUrl('http://shop.jc001.cn/1416529/about/');
		$html = str_get_html($str);
	}
	
	public function actionLocation()
	{
		$str = Yii::app()->fetch->readUrl('http://shop.jc001.cn/list/');
		$html = str_get_dom($str);
		foreach ($html->find('.cditItem', 1)->find('ul li') as $liDom)
		{
			$model = new Location();
			$model->location = $liDom->plaintext;
			$url = $liDom->firstChild()->href;	//搜索地区的URL地址
			/*
			 * 获得地区ID， 与九正的地区ID一致
			 */
			$model->location_id = rtrim(substr($url, 24), '/');
			
			$model->data_catch_url = 'http://shop.jc001.cn/list/';
			
			if ($model->save()) {
				$str = Yii::app()->fetch->readUrl($url);
				$html = str_get_dom($str);
				$html = $html->find('.cditItem', 1);
				if ($html->firstChild()->plaintext == '地&nbsp;&nbsp;区') {
					foreach ($html->find('ul li') as $liDom) {
						$modelChild = new Location();
						$modelChild->location_id = rtrim(substr($liDom->firstChild()->href, 24), '/');
						$modelChild->location = $liDom->plaintext;
						$modelChild->parent_id = $model->location_id;
						$modelChild->data_catch_url = $url;
						$modelChild->save();
					}
				}
				echo $model->location."\n";
			}
		}		
	}
	
	public function actionSearchCategory()
	{
		$searchUrl = unserialize(file_get_contents(Yii::getPathOfAlias('application.modules.jc001.data').'/category_search_company.txt'));
		foreach ($searchUrl as $categoryId => $url) {
			//$str = Yii::app()->fetch->readUrl($url);
			if ($categoryId > 264) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$this->searchInCategory($url, $categoryId);
					$transaction->commit();
					echo "Catgory:".$categoryId."finished.\n";
				}
				catch (Exception $e) {
					var_dump($e->getCode());
					$transaction->rollback();
				}
			}
		}
	}
	
	/**
	*	@description 在从得到的分类表中搜索子分类，并获得子分类的搜索URL
	*/
	private function searchInCategory($url, $parentCategoryId)
	{
		echo $url."\n";
		$str = Yii::app()->fetch->readUrl($url);
		$html = str_get_dom($str);
		$htmlSearchBar = $html->find('.cditItem',0);
		if ($htmlSearchBar->firstChild()->plaintext == '类&nbsp;&nbsp;别') {
			foreach ($htmlSearchBar->find('ul li') as $liDom) {
				$model = new CompanyCategory();
				$model->category_name = $liDom->plaintext;
				$model->parent_id = $parentCategoryId;
				if ($model->save()) {
					$modelParent = CompanyCategory::loadModel($parentCategoryId);
					$modelParent->has_child = 1;
					$modelParent->save();
					$this->searchInCategory($liDom->firstChild()->href, $model->category_id);
				}
			} 
		}
		else {
			$insertParams = array(
				'search_url' => $url,
				'category_id' => $parentCategoryId,
			);
			Yii::app()->db->createCommand()->insert('jc001_category_search_url', $insertParams);
			
			/*获得子分类的URL地址，并添加到数据库中
			*/
		}
		$html->clear();
		$htmlSearchBar->clear();
		unset($htmlSearchBar);
		unset($html);
	}
	
	public function actionCompanySearch($count)
	{
		/*获得部分最小子分类搜索的URL地址
		*/
		$searchIds = array();
		$command = Yii::app()->db->createCommand()->select('id')->from('jc001_category_search_url')->where('locked=0 AND valid=0')->limit($count);
		foreach ($command->queryAll() as $searchRow) {
			$searchIds[] = $searchRow['id'];
		}
		//标记已经获得URL地址为锁定状态
		Yii::app()->db->createCommand()->update('jc001_category_search_url', array('locked' => 1), 'id IN ('.implode(',', $searchIds).')');
		/*
		根据分类再细分地搜索
		*/
		foreach($searchIds as $id) {
			$trunsaction = Yii::app()->db->beginTransaction();
			try {
				$row = Yii::app()->db->createCommand()->select('category_id, search_url')->from('jc001_category_search_url')->where('id='.$id)->queryRow();
				$this->searchInLocation($row['search_url'],$row['category_id']);
				//搜索成功后，解锁
				Yii::app()->db->createCommand()->update('jc001_category_search_url', array('valid' => 1, 'locked' => 0), 'id='.$id);
				$trunsaction->commit();
			}
			catch (Exception $e) {
				echo $e->getMessage()."\n";
				$trunsaction->rollback();
			}
		}
	}
	
	private function searchInLocation($url, $categoryId)
	{
		echo $url."\n";
		sleep(rand(0, 1));
		$str = Yii::app()->fetch->readUrl($url);
		$html = str_get_dom($str);
		$htmlSearchBar = $html->find('.cditItem',0);
		if ($htmlSearchBar->firstChild()->plaintext == '地&nbsp;&nbsp;区') {
			foreach ($htmlSearchBar->find('ul li') as $liDom) {
				$this->searchInLocation($liDom->firstChild()->href, $categoryId);
			}
		}
		else {
			$modelSearch = new CompanySearch();
			$modelSearch->search_url = $url;
			$modelSearch->category_id = $categoryId;
			/*
			 * 获得地区
			 */
			$locationId = rtrim(substr($url, strpos($url, '-r1-') + 4), '/');
			$modelSearch->location_id = $locationId;
			/*
			 * 获得总公司数
			 */
			preg_match('/<p>共找到\s+<strong class="red">(\d+)<\/strong>\s+条记录<\/p>/isU', $str, $match);
			$modelSearch->items = $match[1];
			/*
			 * 获得总页数
			 */
			preg_match('/共(\d+)页/isU', $str, $match);
			$modelSearch->pages = $match[1];
			$modelSearch->save();
		}
		$html->clear();
		$htmlSearchBar->clear();
		unset($html);
		unset($htmlSearchBar);
	}
	
	public function actionCompany($count)
	{
		/*
		 * 获得部分公司搜索ID
		 */
		$searchIds = array();
		$command = Yii::app()->db->createCommand()->select('search_id, search_url')->from('jc001_company_search')->where('locked=0 AND valid=0')->limit($count);
		foreach ($command->queryAll() as $searchRow) {
			$searchIds[] = $searchRow['search_id'];
		}
		
		//锁定已经得到搜索列
		Yii::app()->db->createCommand()->update('jc001_company_search', array('locked' => 1), 'search_id IN ('.implode(',', $searchIds).')');
		
		/*
		 * 根据公司搜索URL地址获得公司基本信息
		*/
		foreach ($searchIds as $searchId) {
			sleep(rand(0,1));
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$row = Yii::app()->db->createCommand()->from('jc001_company_search')->where('search_id='.$searchId)->queryRow();
				$i = 0;
				while ($i++ < $row['pages']) {
					
					$companyInfo = array();
					$companyType = array(
						'生产商' => 1,
						'销售商' => 2,
					);
					
					$url = $row['search_url'].'?p='.$i;
					$str = Yii::app()->fetch->readUrl($url);
					$html = str_get_dom($str);
					
					//$html = $html->find('tbody');
					//获得页面中的公司信息
					$j = 0;
					foreach ($html->find('tr') as $tr) {
						if ($j === 0) {
							++$j; 
							continue;
						}
						$logoUrl = '';
						if ($tr->children(0)->children(0)->innertext) {
							$logoUrl = $tr->children(0)->children(0)->children(0)->src;
						}
						$companyInfo['logo'] = $logoUrl;
						$companyInfo['company_url'] = $tr->children(1)->children(0)->children(0)->href;
						$companyInfo['company_name'] = $tr->children(1)->children(0)->children(0)->innertext;
						//VIP 等级
						$vip = 0;
						if ($tr->children(1)->children(0)->children(1)->tag == 'img') {
							$vipImg = $tr->children(1)->children(0)->children(1)->src;
							$vip = substr(substr($vipImg, strrpos($vipImg, '/')), 1, 1);
						}
						$companyInfo['vip'] = $vip;
						//获得公司类型
						//var_dump($tr->children(1)->children(2)->plaintext);exit;
						$strCompanyType = substr(trim($tr->children(1)->children(2)->plaintext),8,9);
						$companyInfo['type'] = $companyType[$strCompanyType];
						$companyInfo['category_id'] = $row['category_id'];
						$companyInfo['location_id'] = $row['location_id'];
						$companyInfo['data_catch_url'] = $url;
						
						
						//保存公司数据
						$model = new Company();
						$model->attributes = $companyInfo;
						$model->save();
						
						//在进程表添加公司ID，实现公司联系表，公司详情表的进度检查
						Yii::app()->db->createCommand()->insert('jc001_process', array('id' => $model->company_id, 'type' => Process::TYPES_COMPANY_INFO));
						Yii::app()->db->createCommand()->insert('jc001_process', array('id' => $model->company_id, 'type' => Process::TYPES_COMPANY_CONTACT));
					}
					
					//清理simple dom对象，释放内存
					$tr->clear();
					unset($tr);
					$html->clear();
					unset($html);
					unset($str);
				}
				
				//标记已经搜索成功的项目的状态为已经获得，并解除锁定
				Yii::app()->db->createCommand()->update('jc001_company_search', array('locked' => 0, 'valid' => 1), 'search_id='.$searchId);
				
				$transaction->commit();
				
				//查看进度结果
				echo $row['search_url']."\n";
			}
			catch (Exception $e) {
				echo $e->getMessage()."\n";
				$transaction->rollback();
			}
		}
	}
	
	private function saveImage($imgUrl)
	{
		$imgContent = Yii::app()->fetch->fetchRaw($imgUrl);
		
		$fileName = substr($imgUrl, strrpos($imgUrl, '/') + 1);
		var_dump($fileName);
		$fileDirPath = (Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.date(Ymd));
		is_dir($fileDirPath) || mkdir($fileDirPath, 0777, true);
		$md5Part =  md5($fileName . '-' . microtime(true));
		$filePath = $fileDirPath.DIRECTORY_SEPARATOR.$md5Part.substr($imgUrl, strrpos($imgUrl, '.'));
		$imgFileHandle = fopen($filePath, 'w+');
		fwrite($imgFileHandle, $imgContent);
		fclose($imgFileHandle);
		return $filePath;
	}
	
	public function actionContact($count)
	{
		
		$alias = array(
			'地址' => 'address',
			'邮编' => 'postcode',
			'联系人' => 'contact_user',
			'电话' => 'telephone',
			'手机' => 'mobile',
			'传真' => 'fax',
			'邮箱' => 'email',
			'网址' => 'extend_url',
			'与商家联系' => 'qq',
		);
		//获得指定数量的company_id
		$ids = $this->getUnlockedId(Process::TYPES_COMPANY_CONTACT, $count);
		foreach ($ids as $id) {
		
			sleep(rand(0,1));
			
			$contact = array(
				'contact_url' => '',
				'contact_user' => '',
				'email' => '',
				'telephone' =>'',
				'fax' => '',
				'mobile' => '',
				'postcode' => '',
				'address' => '',
				'extend_url' => '',
				'qq' => '',
			);
			
			$companyUrl = array_pop(Yii::app()->db->createCommand()->select('company_url')->from('jc001_company')->where('company_id='.$id)->queryRow());
			$contactUrl = $companyUrl.'contact.html';
			$contact['company_id'] = $id;
			$contact['contact_url'] = $contactUrl;
			
			echo $contactUrl."\n";
			
			$str = Yii::app()->fetch->readUrl($contactUrl);
			if ($str) {
				$html = str_get_dom($str);
				$i = 0;
				foreach ($html->find('.cl') as $td) {
					switch ($td->innertext) {
						case '公司':
							break;
						case '邮箱':
							//截取生存邮件链接的js代码，并获取写邮件的ASC码
							$jsCode = '';
							$jsCode = trim($html->find('.cr', $i)->firstChild()->innertext);
							$ascCode = substr($jsCode,  strpos($jsCode, '(', 22) + 1, strpos($jsCode, ')') - strpos($jsCode, '(', 22) - 1);
							$emailLink = '';
							foreach (explode(',', $ascCode) as $code) {
								$emailLink .= chr($code);	//转化ASC码为字符
							}
							$contact['email'] = strip_tags($emailLink);
							break;
						case '网址':
							$jsCode = '';
							$jsCode = trim($html->find('.cr', $i)->firstChild()->innertext);
							$encode = UtilityHelper::subString($jsCode, '(', ')', 10);
							$contact['extend_url'] = trim(strip_tags(UtilityHelper::subString(urldecode($encode), "(", ")")),"'");
							break;
						case '与商家联系':
							$qqUrl = $td->nextSibling()->firstChild()->href;
							$start = strpos($qqUrl, 'Uin=') + 4;
							$qq = substr($qqUrl, $start, strpos($qqUrl, '&Site') - $start);
							$contact['qq'] = $qq;
							break;
						default:
							if (in_array($td->innertext, array_keys($alias))) {
								$contact[$alias[$td->innertext]] = trim(str_replace('&nbsp;', '', $td->nextSibling()->plaintext));
							}
							break;
					}
					$i++;
				}
				$td->clear();
				$html->clear();
				unset($td);
				unset($html);
				
				//添加到联系表
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$model = new CompanyContact();
					$model->attributes = $contact;
					if ($model->validate()) {
						$model->save();
						$this->validId(Process::TYPES_COMPANY_CONTACT, $id);
						$transaction->commit();
					}
					else {
						var_dump($model->getErrors());
						$transaction->rollback();
					}
					//在进程表里面标记为已经获得
				
				}
				catch (Exception $e) {
					$transaction->rollback();
					echo $e->getMessage()."\n";
				}
			}
		}
	}
	
	
	private function getUnlockedId($type, $count)
	{
		$id = array();
		foreach (Yii::app()->db->createCommand()->select('id')->from('jc001_process')->where('locked=0 AND valid=0 AND type='.$type)->limit($count)->queryAll() as $row) {
			$id[] = $row['id'];
		}
		//锁定
		Yii::app()->db->createCommand()->update('jc001_process', array('locked' => 1), 'type='.$type.' AND id IN('.implode(',', $id).')');
		return $id;
	}
	
	private function validId($type, $id)
	{
		Yii::app()->db->createCommand()->update('jc001_process', array('locked' => 0, 'valid' => 1), 'type='.$type.' AND id='.$id);
	}
	
	
	public function actionInfo($count)
	{
		
		$matchKey = array(
			'注册资本(￥)' => 'capital',
			'公司成立时间' => 'register_date',
			'公司注册地' => 'register_location',
			'法人/负责人' => 'legal',
			'开户银行' => 'bank',
			'帐号' => 'account',
			'厂房面积' => 'acreage',
			'品牌名称' => 'brand',
			'员工人数' => 'employee',
			'研发部门人数' => 'developer',
			'年营业额' => 'turnover',
			'管理体系认证' => 'certify',
			'质量控制' => 'quality',
			'主要市场' => 'market',
			'主要客户群' => 'costomer',
		);
		
		$ids = $this->getUnlockedId(Process::TYPES_COMPANY_INFO, $count);
		foreach ($ids as $id) {
			$transaction = Yii::app()->db->beginTransaction();
			
			try {
				
				$model = new CompanyInfo();
				$model->company_id = $id;
				$companyUrl = array_pop(Yii::app()->db->createCommand()->select('company_url')->from('jc001_company')->where('company_id='.$id)->queryRow());
				$aboutUrl = $companyUrl.'about/';
				$model->data_catch_url = $aboutUrl;
				
				//当前获取的URl
				echo $aboutUrl."\n";
				
				$str = Yii::app()->fetch->readUrl($aboutUrl);
				$html = str_get_html($str);
				
				//获得公司主营产品
				$cutFrom = $html->find('.shopName', 0)->children(1)->firstChild()->tag == 'span' ? 28 : 15;
				$model->products = substr($html->find('.shopName', 0)->children(1)->plaintext, $cutFrom);
				//公司详情
				$lenIntroduce = count($html->find('.cnt',0)->children()) - 1;
				$introduce = '';
				if ($lenIntroduce == 0) {
					$tmpInfo = $html->find('.cnt',0)->innertext;
					$introduce = substr($tmpInfo, 0,strpos($tmpInfo, '<table'));
				}
				else {
					$i = 0;
					while ($i < $lenIntroduce) {
						$introduce .= $html->find('.cnt',0)->children(0)->outertext;
						$i++;
					}
				}
				$model->introduce = trim($introduce);
				
				//其他属性
				foreach ($html->find('th') as $th) {
					$title = trim($th->innertext);
					$model->{$matchKey[$title]} = trim($th->nextSibling()->innertext);
				}
				//清理html dom对象
				$html->clear();
				unset($html);
				unset($str);
				
				if ($model->validate()) {
					$model->save();
					$this->validId(Process::TYPES_COMPANY_INFO, $id);
					$transaction->commit();
				}
				else {
					print_r($model->getErrors());
					$transaction->rollback();
				}
				
			}
			catch (Exception $e) {
				echo $e->getMessage()."\n";
				$transaction->rollback();
			}
		}
	}
}