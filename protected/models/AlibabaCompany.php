<?php
class AlibabaCompany extends CAlibaba
{
	
	protected $connection;
	private $_intMatch = 10;
	
	public function __construct()
	{
		parent::__construct();
		$this->connection = Yii::app()->db;
		$this->_objFetch->maxredirs = 0;
	}
	
	public function getSearchList($strUrl, $strCategory)
	{
		$connection=Yii::app()->db;
		$sql="INSERT INTO company_search_result (url,category,province,company_num,data_catch_url) VALUES(:url,:category,:province,:company_num,:data_catch_url)";
		$command = $connection->createCommand($sql);
		$command->bindParam(':category', $strCategory, PDO::PARAM_STR);
		$command->bindParam(':data_catch_url', $strUrl, PDO::PARAM_STR);
		
		$str = $this->_objFetch->readUrl($strUrl);
		preg_match_all('/<div class="sc-item-list">\s+<ul>(.+)<\/ul>\s+<\/div>\s+<div class="sc-item-name">\s+<h4>(.+)<\/h4>\s+<\/div>/isU', $str, $match_province, PREG_SET_ORDER);
		foreach ($match_province as $arrMatch) {
			if ($arrMatch[2] == '省份') {
				$strProvinceHtmlMatch = $arrMatch[1];
				break;
			}
		}
		if (isset($strProvinceHtmlMatch) && $strProvinceHtmlMatch) {
			preg_match_all('/<li(| class="c-hidden")><a href="([^\s]+)"\s+onmousedown="[^\s]+"\s+title="(.+)" target="_self">.+<\/a><i title="(\d+)">\(\d+\)<\/i><\/li>/isU', $strProvinceHtmlMatch, $matches, PREG_SET_ORDER);
			foreach ($matches as $match) {
				$command->bindParam(':province', $match[3], PDO::PARAM_STR);
				$command->bindParam(':company_num', $match[4], PDO::PARAM_INT);
				$command->bindParam(':url', $match[2], PDO::PARAM_INT);
				$command->execute();
				echo $connection->getLastInsertID()."\n";
			}
		}
		else {
			preg_match('/<p class="search-result">共找到<em>(\d+)<\/em>/isU', $str, $match_num);
			$command->bindValue(':province', '未知', PDO::PARAM_STR);
			$command->bindParam(':company_num', $match_num[1], PDO::PARAM_INT);
			$command->bindParam(':url', $strUrl, PDO::PARAM_INT);
			$command->execute();
			echo $connection->getLastInsertID()."\n";
		}
	}
	
	public function getSearchListPage()
	{
		$connection=Yii::app()->db;
		$command = $connection->createCommand('UPDATE company_search_result SET page_num=:page_num,locked=1 WHERE id=:id');
		foreach ($connection->createCommand("SELECT * FROM company_search_result WHERE locked = 0")->queryAll() as $arrRow) {
			$str = $this->_objFetch->readUrl($arrRow['url']);
			if (preg_match('/<span class="total-page">共<b>(\d+)<\/b>页/isU', $str, $match_page))
				$command->bindParam(':page_num', $match_page[1], PDO::PARAM_INT);
			else 
				$command->bindValue(':page_num', 1, PDO::PARAM_INT);
				
			$command->bindParam(':id', $arrRow['id'], PDO::PARAM_INT);
			$command->execute();
			echo "ID:".$arrRow['id']."\n";
			CCommonFunction::sleepWhile(0, 5);
		}
	}
	
	public function getCompanyUrl($arrId = array())
	{
		$command = $this->connection->createCommand('INSERT INTO company (company_name,category,province,company_url,data_catch_url) VALUES(:company_name,:category,:province,:company_url,:data_catch_url)');
		if (!is_array($arrId) || empty($arrId)) {
			foreach ($this->connection->createCommand("SELECT id FROM company_search_result WHERE valid=0")->queryAll() as $arrRow) {
				$arrId[] = $arrRow['id'];
			}
		}
		
		foreach ($arrId as $intId) {
			$arrRow = $this->connection->createCommand("SELECT * FROM company_search_result WHERE id=".$intId)->query()->read();
			$command->bindParam(':category', $arrRow['category'], PDO::PARAM_STR);
			$command->bindParam(':province', $arrRow['province'], PDO::PARAM_STR);
			
			$i = 0;
			$intGetCompanyNum = 0;
			$strUrlTail = substr($arrRow['url'], strpos($arrRow['url'], '_province'));
			$strUrlHead = substr($arrRow['url'], 0,strpos($arrRow['url'], '_province'));
			$strCurrentUrl = '';
			
			while ($i++ < $arrRow['page_num']) {
				$strCurrentUrl = $strUrlHead.'_p-'.$i.$strUrlTail;
				//$strCurrentUrl = "http://search.china.alibaba.com/company/c-1032600_p-10_province-%BA%D3%B1%B1_n-y.html";
				$command->bindParam(':data_catch_url', $strCurrentUrl, PDO::PARAM_STR);
				$str = $this->_objFetch->readUrl($strCurrentUrl);
				preg_match_all('/<span class="m undline"><a gotoDetail="1" href="([^\s]+)"  onmousedown="[^\s]+" target="_blank" class="l">(.+)<\/a><\/span>/isU', $str, $matches, PREG_SET_ORDER);
				//var_dump($matches);exit;
				echo $strCurrentUrl.":".count($matches)."|Id:".$intId."\n";
				foreach ($matches as $arrMatch) {
					$command->bindParam(':company_url', $arrMatch[1], PDO::PARAM_STR);
					$command->bindParam(':company_name', $arrMatch[2], PDO::PARAM_STR);
					$command->execute();
					$intGetCompanyNum++;
				}
				CCommonFunction::sleepWhile(0, 2);
			}
			$this->connection->createCommand("UPDATE company_search_result SET valid_page_num=".($i-1).",valid_company_num=".$intGetCompanyNum.",valid=1,locked=0 WHERE id=".$intId)->execute();
		}
	}
	
	public function getVipCompany()
	{
		
	}
	
	public function getCompanyContact($arrId = array())
	{
		$command = $this->connection->createCommand('INSERT INTO company_contact (company_id,url,company_url,contact_user,gender,duty,telephone,mobile,fax,wangwang,address,postcode,extend_company_url) VALUES
			(:company_id,:url,:company_url,:contact_user,:gender,:duty,:telephone,:mobile,:fax,:wangwang,:address,:postcode,:extend_company_url)');
		
		if (!is_array($arrId) || empty($arrId)) {
			foreach ($this->connection->createCommand("SELECT company_id FROM company WHERE valid_contact=0")->queryAll() as $arrRow) {
				$arrId[] = $arrRow['company_id'];
			}
		}
		
		foreach ($arrId as $intCompanyId) {
			
			$command->bindParam(':company_id', $intCompanyId);
			$arrContactInfoComplete = array('url'=>'','company_url' => '','contact_user'=>'','gender'=>0,'duty'=>'','telephone'=>'','fax'=>'','mobile'=>'','wangwang'=>'','address'=>'','postcode'=>'','extend_company_url'=>'');
			$arrRow = $this->connection->createCommand("SELECT * FROM company WHERE company_id = ".$intCompanyId)->query()->read();
			$this->_objFetch->readUrl($arrRow['company_url']);
			$strLastUrl = strpos($this->_objFetch->readUrl($arrRow['company_url']), 'http://') === 0 ? $this->_objFetch->readUrl($arrRow['company_url']) : $arrRow['company_url'];
			echo $strLastUrl."|CompanyID:".$intCompanyId."\n";
			if (preg_match('/http:\/\/([a-z0-9]+).cn.alibaba.com\//isU', rtrim($strLastUrl, '/').'/', $match_url)) {
				$arrContactInfo = $this->getVipCompanyContact($match_url[1]);
			}
			else if (preg_match('/http:\/\/china.alibaba.com\/company\/detail\/([a-z0-9]+).html/isU', $strLastUrl)) {
				$arrContactInfo = $this->getNotVipCompanyContact($arrRow['company_url']);
			}
			else if (preg_match('/http:\/\/company.china.alibaba.com\/athena\/([a-z0-9]+).html/isU', $strLastUrl, $match_url)) {
				
				$arrContactInfo = $this->getVipCompanyContact($match_url[1]);
			}
			else {
			}
			/* 添加到数据库
			 * */
			if (is_array($arrContactInfo) && $arrContactInfo) {
				foreach ($arrContactInfo as $strKey => $mixValue) {
					$arrContactInfoComplete[$strKey] = $mixValue;
				}
				foreach ($arrContactInfoComplete as $strField => $strValue) {
					$command->bindValue(':'.$strField, $strValue);
				}
				$command->execute();
			}
			$this->connection->createCommand("UPDATE company SET valid_contact = 1 AND locked_contact = 0 WHERE company_id=".$intCompanyId."")->execute();
		}
	}
	
	public function getSubCompanyId($intCount)
	{
		foreach ($this->connection->createCommand("SELECT id FROM company_search_result WHERE valid=0 AND locked=0 LIMIT 0,".$intCount)->query()->readAll() as $arrRow) {
			$arrId[] = $arrRow['id'];
			$this->connection->createCommand("UPDATE company_search_result SET locked=1 WHERE id=".$arrRow['id'])->execute();
		}
		return $arrId;
	}
	
	
	public function getSubCompanyIdForContact($intCount)
	{
		foreach ($this->connection->createCommand("SELECT company_id FROM company WHERE valid_contact=0 AND locked_contact=0 LIMIT 0,".$intCount)->query()->readAll() as $arrRow) {
			$arrId[] = $arrRow['company_id'];
			$this->connection->createCommand("UPDATE company SET locked_contact=1 WHERE company_id=".$arrRow['company_id'])->execute();
		}
		return $arrId;
	}
	
	private function getVipCompanyContact($strCompanyId)
	{
		$strUrl = "http://".$strCompanyId.".cn.alibaba.com/athena/contact/".$strCompanyId.".html";
		$str = $this->_objFetch->readUrl($strUrl);
		if (preg_match('/<title>您所访问的旺铺已到期或已被删除<\/title>/isU', $str)) {
			return $this->getNotVipCompanyContact('http://china.alibaba.com/company/detail/'.$strCompanyId.'.html');
		}
		else {
			if(preg_match('/<dt>联系人：<\/dt>\s+<dd>\s+<a class="topicLink draft_no_link" href="[^\s]+" target="_blank".+>(.+)<\/a>&nbsp;(先生|女士|)（(.*)）&nbsp;&nbsp;.+<\/dd>/isU', $str, $match_contact)) {
				$arrContactInfo['company_url'] = "http://".$strCompanyId.".cn.alibaba.com/";
				$arrContactInfo['url'] = $strUrl;
				$arrContactInfo['contact_user'] = $match_contact[1];
				$arrContactInfo['gender'] = $match_contact[2] == '先生' ? 1 : ($match_contact[2] == '女士' ? 2 : 0);
				$arrContactInfo['duty'] = $match_contact[3];
				
				preg_match('/<a alitalk="{id:\'[a-z0-9]+\',siteID:\'[a-z0-9]+\',type:\d{1}}" class="alitalk-btn" href="#" onmousedown="aliclick\(this, \'\?info_id=(\d+)\'\);traceXunpanLog\(this,\'[a-z0-9]+\',\'\',\'\'\);return traceParrotStatLog\(this, \'alitalk\', \'[a-z0-9]+\', \'athena\'\);"><\/a>/isU', $str, $match_wangwang);
				$arrContactInfo['wangwang'] = $match_wangwang[1];
				
				preg_match('/<ul class="mainTextColor">(.+)<\/ul>/isU', $str, $match_content);
				preg_match_all('/<li\s?>(.+)：(.+)<\/li>/isU', $match_content[1], $matches, PREG_SET_ORDER);
				foreach ($matches as $arrMatchContactInfo) {
					switch (str_replace('&nbsp;','',$arrMatchContactInfo[1])) {
						case '电话':
							$arrContactInfo['telephone'] = trim($arrMatchContactInfo[2]);
							break;
						case '移动电话':
							$arrContactInfo['mobile'] = trim($arrMatchContactInfo[2]);
							break;
						case '地址':
							$arrContactInfo['address'] = trim($arrMatchContactInfo[2]);
							break;
						case '邮编':
							$arrContactInfo['postcode'] = trim($arrMatchContactInfo[2]);
							break;
						case '传真':
							$arrContactInfo['fax'] = trim($arrMatchContactInfo[2]);
							break;
						case '公司主页':
							preg_match_all('/<a(|\s+style="margin-left:67px")\s+class="draft_no_link topicLink" href="([^\s]+)" target="_blank">[^\s]+<\/a>/isU', $arrMatchContactInfo[2], $matches_url);
							$arrContactInfo['extend_company_url'] = implode('|', $matches_url[2]);
							break;
						default:
							break;
					}
				}
				return $arrContactInfo;
			}
			else {
				return $this->getVipCompanyContactAthena($strCompanyId);
			}
		}
	}
	
	private function getVipCompanyContactAthena($strCompanyId)
	{
		$strUrl = "http://".$strCompanyId.".cn.alibaba.com/athena/contact/".$strCompanyId.".html|Athena";
		//echo $strUrl."\n";
		$str = $this->_objFetch->readUrl($strUrl);
		if (preg_match('/<title>您所访问的旺铺已到期或已被删除<\/title>/isU', $str)) {
			return $this->getNotVipCompanyContact('http://china.alibaba.com/company/detail/'.$strCompanyId.'.html');
		}
		else {
			if (preg_match('/<dt>联&nbsp;系&nbsp;&nbsp;人：<\/dt>\s+<dd>\s+<a href="[^\s]+" class="membername" target="_blank">(.+)<\/a>\s+(先生|女士)\s+\((.+)\).+<\/dd>/isU', $str, $match_contact)) {
				$arrContactInfo['company_url'] = "http://company.china.alibaba.com/athena/".$strCompanyId.".html";
				$arrContactInfo['url'] = $strUrl;
				
				$arrContactInfo['contact_user'] = $match_contact[1];
				$arrContactInfo['gender'] = $match_contact[2] == '先生' ? 1 : 2;
				$arrContactInfo['duty'] = $match_contact[3];
				
				preg_match('/<a href="#" class="alitalk" data-alitalk="{id: \'([a-z0-9]+)\'}"><\/a>/isU', $str, $match_wangwang);
				$arrContactInfo['wangwang'] = $match_wangwang[1];
				
				preg_match('/<div class="props-part">(.+)<\/div>\s+<\/div>\s+<!--\/m-content-->/isU', $str, $match_content);
				preg_match_all('/<dl>\s+<dt>(.+)：<\/dt>\s+<dd>(.+)<\/dd>\s+<\/dl>/isU', $match_content[1], $matches, PREG_SET_ORDER);
				foreach ($matches as $arrMatchContactInfo) {
					switch (str_replace('&nbsp;','',$arrMatchContactInfo[1])) {
						case '电话':
							$arrContactInfo['telephone'] = trim($arrMatchContactInfo[2]);
							break;
						case '移动电话':
							$arrContactInfo['mobile'] = trim($arrMatchContactInfo[2]);
							break;
						case '地址':
							$arrContactInfo['address'] = trim($arrMatchContactInfo[2]);
							break;
						case '邮编':
							$arrContactInfo['postcode'] = trim($arrMatchContactInfo[2]);
							break;
						case '传真':
							$arrContactInfo['fax'] = trim($arrMatchContactInfo[2]);
							break;
						case '公司主页':
							preg_match_all('/<div>\s+<a href="(.+)" class="[A-Za-z0-9\-_]+" target="_blank">(.+)<\/a>\s+<\/div>/isU', $arrMatchContactInfo[2], $matches_url);
							$arrContactInfo['extend_company_url'] = implode('|', $matches_url[2]);
							break;
						default:
							break;
					}
				}
				return $arrContactInfo;
			}
			else {
				return array();
			}
		}
	}
	
	public function getNotVipCompanyContact($strCompanyUrl)
	{
		$strUrltail = substr($strCompanyUrl, strrpos($strCompanyUrl, '/'));
		$strContactUrl = substr($strCompanyUrl, 0,strrpos($strCompanyUrl, '/')).'/contact'.$strUrltail;
		$str = $this->_objFetch->readUrl($strContactUrl);
		if ($this->_objFetch->lastredirectaddr != $strContactUrl && strpos($this->_objFetch->lastredirectaddr, 'http://') !== false) {
			if (preg_match('/http:\/\/([a-z0-9]+).cn.alibaba.com\//isU', rtrim($this->_objFetch->lastredirectaddr, '/').'/', $match_url)) {
				return $this->getVipCompanyContact($match_url[1]);
			}
		}
		else {
			preg_match('/<h4 class="fn"><a href="[^\s]+" class="uol" target="_blank">(.+)<\/a>(|<sup>(先生|女士)<\/sup>)<\/h4><p><span class="role">(.*)<\/span>/isU', $str, $match_contact);
			$arrContactInfo['contact_user'] = $match_contact[1];
			$arrContactInfo['gender'] = $match_contact[3] == '先生' ? 1 : 2;
			$arrContactInfo['duty'] = $match_contact[4];
			preg_match('/<a id="alitalkTxtNameA" onmousedown="eqTraceLog\(\);traceParrotStatLog\(this, \'alitalk\', \'[a-z0-9]+\',\'companydetail\',\'(\d+)\'\);return aliclick\(this,\'\?tracelog=company_ty_lxmyt\'\);" href="#"><span id="alitalkNameTxt" ><\/span><\/a>/isU', $str, $match_wangwang);
			$arrPattern = array(
				'address' => '/<p class="adr"><abbr class="type" title="work">地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：<\/abbr><span class="value" title="">(.+)<\/span><\/p>/isU',
				'telephone' => '/<p class="tel"><abbr class="type" title="work">电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话：<\/abbr><span class="value">(.+)<\/span><\/p>/isU',
				'mobile' => '/<p class="tel"><abbr class="type" title="cell">移动电话：<\/abbr><span class="value">(.*)<\/span>\s+<\/p>/isU',
				'postcode' => '/<p class="postal-code "><abbr class="type" title="work">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编：<\/abbr><span class="value">(.*)<\/span>\s+<\/p>/isU',
				'fax' => '/<p class="tel"><abbr class="type" title="fax">传&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;真：<\/abbr><span class="value">(.+)<\/span>\s+<\/p>/isU',
			);
			foreach ($arrPattern as $strKey => $strParrent) {
				preg_match($strParrent, $str, $match);
				$arrContactInfo[$strKey] = trim($match[1]);
			}
			
			preg_match('/<div class="site">\s+<abbr>公司网址：<\/abbr><span class="url">(.+)<\/span>\s+<\/div>/isU', $str, $match_url);
			preg_match_all('/<a href="([^\s]+)" target=_blank>[^\s]+<\/a>/isU', $match_url[1],$arrMatchUrls, PREG_SET_ORDER);
			if (isset($arrMatchUrl[0][1])) {
				foreach ($arrMatchUrl as $arrUrl) {
					$arrCompanyUrl[] = $arrUrl[1];
				}
				$arrContactInfo['extend_company_url'] = implode('|', $arrCompanyUrl);
			}
			else {
				$arrContactInfo['extend_company_url'] = '';
			}
			$arrContactInfo['company_url'] = $strCompanyUrl;
			$arrContactInfo['url'] = $strContactUrl;
			return $arrContactInfo;
		}
	}
	
	public function getCompanyInfo($arrId)
	{
		
		$command = $this->connection->createCommand('');
		
		if (!is_array($arrId) || empty($arrId)) {
			foreach ($this->connection->createCommand("SELECT company_id FROM company WHERE valid_info=0")->queryAll() as $arrRow) {
				$arrId[] = $arrRow['company_id'];
			}
		}
		
		foreach ($arrId as $intCompanyId) {
			$command->bindParam(':company_id', $intCompanyId);
			
			$arrContactInfoComplete = array('url'=>'','company_url' => '','contact_user'=>'','gender'=>0,'duty'=>'','telephone'=>'','fax'=>'','mobile'=>'','wangwang'=>'','address'=>'','postcode'=>'','extend_company_url'=>'');
			$arrRow = $this->connection->createCommand("SELECT * FROM company WHERE company_id = ".$intCompanyId)->query()->read();
			$str = $this->_objFetch->readUrl($arrRow['company_url']);
			/*
			 * 如果商户不存在
			 */
			if (preg_match('/<title>您所访问的旺铺已到期或已被删除<\/title>/isU', $str)) {
				$arrContactInfo = $this->getNotVipCompanyInfo($arrRow['company_url']);
			}
			else {
				$strLastUrl = strpos($this->_objFetch->readUrl($arrRow['company_url']), 'http://') === 0 ? $this->_objFetch->readUrl($arrRow['company_url']) : $arrRow['company_url'];
				
				if (preg_match('/http:\/\/([a-z0-9]+).cn.alibaba.com\//isU', rtrim($strLastUrl, '/').'/', $match_url)) {
					$arrContactInfo = $this->getVipCompanyInfo($match_url[1]);
				}
				else if (preg_match('/http:\/\/china.alibaba.com\/company\/detail\/([a-z0-9]+).html/isU', $strLastUrl)) {
					$arrContactInfo = $this->getNotVipCompanyInfo($arrRow['company_url']);
				}
				else if (preg_match('/http:\/\/company.china.alibaba.com\/athena\/([a-z0-9]+).html/isU', $strLastUrl, $match_url)){
					$arrContactInfo = $this->getVipCompanyInfo($match_url[1]);
				}
			}
		}
		
	}
	
	private function getVipCompanyInfo($strCompanyId)
	{
		$arrCompanyInfo = array();
		
		$strInfoUrl = "http://".$strCompanyId.".cn.alibaba.com/athena/companyprofile/".$strCompanyId.".html";
		$str = $this->_objFetch->readUrl($strInfoUrl);
		preg_match('/<div class="bodyContTitle"><span class="fl b titleLinkColor titleName">公司介绍<\/span><\/div>\s+<div class="companyinfo mainTextColor" style="word-break:break-all;zoom:1;">\s+<script  language="javascript" type="text\/javascript">.+<\/script>(.+)<\/div>\s+<div style="clear:both"><\/div>/isU', $str, $match_description);
			
		preg_match('/<div class="bodyContTitle"><span class="fl b titleLinkColor titleName">详细信息<\/span><\/div>\s+<div class="bodyContContent rel" style="text-align:center;">\s+<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">(.+)<\/table>\s+<\/div>/isU', $str, $match);
		preg_match('/<tr>\s+<td width="17%" bgcolor="#F0f0f0" class="S lh15" style="padding-top:3px;padding-right:3px; padding-bottom:3px; ">\s+<div align="right">\s+<strong><a href="[^\s]+" class=" draft_no_link">主营产品或服务<\/a>：<\/strong>\s+<\/div>\s+<\/td>\s+<td width="33%" bgcolor="#FFFFFF" class="S lh15" style="padding-top:3px; padding-left:5px; padding-right:5px; padding-bottom:3px; " style="word-break:break-all" align="left">(.+)<td width="17%" bgcolor="#F0f0f0" class="S lh15" style="padding-top:3px;padding-right:3px; padding-bottom:3px; ">\s+<div align="right"><strong>主营行业：<\/strong>\s+<\/div>\s+<\/td>\s+<td width="33%" valign="top" bgcolor="#FFFFFF" class="S lh15" style="padding-top:3px; padding-left:5px; padding-right:5px; padding-bottom:3px; " align="left">(.+)<\/td>\s+<\/tr>/isU', $match[1], $match_base);
		$arrInfo['products'] = $match_base[1];
		$arrInfo['dustry'] = $match_base[2];
		
		preg_match_all('/<td bgcolor="#F0f0f0" class="S lh15" style="padding-top:3px;padding-right:3px; padding-bottom:3px;(|font-style:italic;)\s*">\s+<div align="right">\s*<strong>(.+)<\/strong>\s*<\/div>\s*<\/td>\s+<td(| bgcolor="#FFFFFF") class="S lh15" style="padding-top:3px; padding-left:5px; padding-right:5px; padding-bottom:3px;\s*" align="left">(.+)<\/td>/isU', $match[1], $matches);
		return $arrCompanyInfo;
	}
	
	public function getNotVipCompanyInfo($strCompanyUrl)
	{
		$strInfoUrlTail = substr($strCompanyUrl, strrpos($strCompanyUrl, '/'));
		$strInfoUrl = substr($strCompanyUrl, 0, strrpos($strCompanyUrl, '/'))."/intro".$strInfoUrlTail;
		$str = $this->_objFetch->readUrl($strInfoUrl);
		
		preg_match('/<div class="intro-data">(.+)<\/div>\s+<table border="0" cellspacing="0" cellpadding="10" class="about_table">/isU', $str, $match_description);
		preg_match_all('/<tr>\s+<th>\s*([^\s]+)：\s*<\/t[hd]{1}>\s+<th>\s*([^\s]+)：\s*<\/t[hd]{1}>\s+<\/tr>\s+<tr>\s+<td(| class=\'c1\')>(.+)<\/td>\s*<td(| class=\'c1\')>(.+)<\/td>\s+<\/tr>/isU', $str, $matches);
		var_dump($matches);
	}
}
?>
