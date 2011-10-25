<?php
require_once 'Snoopy.class.php';

class CImageConvert extends Snoopy
{
	
	private $_strSavePath;
	private $_strImageName;
	private $_strImageUrl;
	
	public function __construct($strImageUrl)
	{
		$this->_strSavePath = "/var/www/html/data_center/images/";
		$this->_strImageUrl = $strImageUrl;
		$this->autoRenameImage();
	}
	
	public function downloadImage()
	{
		$imageContent = $this->readUrl($this->_strImageUrl);
		
		$handelImageFile = fopen($this->_strSavePath.$this->_strImageName, 'w+');
		fwrite($handelImageFile, $imageContent);
		fclose($handelImageFile);
	}
	
	public function setSavePath($strSavePath)
	{
		$this->_strSavePath = $strSavePath;
	}
	
	public function nameImage($strImageName)
	{
		$this->_strImageName = $strImageName;
	} 
	
	private function autoRenameImage()
	{
		$strExtendName = substr($this->_strImageUrl, strripos($this->_strImageUrl, '.'));
		$this->_strImageName = time().rand(0, 10000).$strExtendName;
	}
	
	public function getImageName()
	{
		return $this->_strImageName;
	}
}
?>