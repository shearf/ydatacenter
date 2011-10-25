<?php
//require_once dirname(__FILE__).'/Snoopy.class.php';

class CFetch implements IApplicationComponent
{
	private $_intRetry = 5;
	
	private $_strInputCharset;
	
	private $_strOutputCharset = "UTF-8";
	
	private $_bCharsetConvert = false;
	
	protected $objSnoopy;
	
	public function __construct()
	{
		$this->objSnoopy = new Snoopy();
		$this->setTimeout(60);
	}
	
	public function setProxy($strProxyHost, $intProxyPort, $strProxyUser='', $strProxyPass = '')
	{
		$this->objSnoopy->proxy_host = $strProxyHost;					// proxy host to use
		$this->objSnoopy->proxy_port = $intProxyPort;					// proxy port to use
		$this->objSnoopy->proxy_user = $strProxyUser;					// proxy user to use
		$this->objSnoopy->proxy_pass = $strProxyPass;	
	}
	public function setInputCharset($strInputCharset)
	{
		$this->_strInputCharset = $strInputCharset;
		if ($this->_strInputCharset != $this->_strOutputCharset)
			$this->_bCharsetConvert = true;
	}
	
	public function setRetry($intRetry)
	{
		$this->_intRetry = $intRetry;
	}
	
	protected function errorLog($strUrl, $intHttpStatus, $bTimeOut) 
	{
		try{
			$connection = Yii::app()->db;
			$connection->createCommand("INSERT INTO failed_links (url,status,timeout) VALUES ('".$strUrl."',".$intHttpStatus.", ".$bTimeOut.")")->execute();
		}catch (CDbException $ex){
			
		}
	}
	
	public function readUrl($strUrl, $intRetry=5)
	{
		try {
			if ($this->objSnoopy->fetch($strUrl) && $this->objSnoopy->results) {
				$str = isset($this->objSnoopy->rawheaders['Accept-Encoding']) && strpos($this->objSnoopy->rawheaders['Accept-Encoding'], 'gzip') !== false ? CCommonFunction::gzdecode($this->objSnoopy->results) : $this->objSnoopy->results;
				$str = $this->_bCharsetConvert ? mb_convert_encoding($str, $this->_strOutputCharset, $this->_strInputCharset) : $str;
				$this->setRetry($intRetry);
				return $str;
			}
			else if ($this->_intRetry-- > 0) {
				$this->readUrl($strUrl);
			}
			else {
				throw new Exception($this->objSnoopy->error, $this->objSnoopy->status);
			}
		}
		catch (Exception $e) {
			$this->errorLog($strUrl, $this->objSnoopy->status, $this->objSnoopy->timed_out === false ? 0 : 1 );
		}
		
	}
	
	public function setHttpHeaders($arrRawHeaders, $strAgent, $strAccept)
	{
		$this->objSnoopy->agent = $strAgent;
		$this->objSnoopy->accept = $strAccept;
		$this->objSnoopy->rawheaders = $arrRawHeaders;
	}
	
	public function autoSetAgent()
	{
		
	}
	
	public function init()
	{
		
	}
	
	public function getIsInitialized()
	{
		
	}
	
	public function setTimeout($intTimeout)
	{
		$this->objSnoopy->timed_out = $intTimeout;
	}
	
	public function fetchRaw($url)
	{
		$this->objSnoopy->fetch($url);
		return $this->objSnoopy->results;
	}
}



?>
