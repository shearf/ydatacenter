<?php
/**
 * @author	xiahaihu2009@gmail.com
 * 
 */
class FetchEdeng extends CFetch
{
	public $timeOut = 60;
	public $retryTimes = 5;
	
	public function __construct()
	{
		parent::__construct();
		parent::setRetry($this->retryTimes);
		$this->timed_out = $this->timeOut;
		//parent::setInputCharset('GBK');
		$this->setHttpHeaders(array(), "Mozilla/5.0 (Windows NT 5.1; rv:7.0) Gecko/20100101 Firefox/7.0", "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8");
	}
	
	protected function errorLog($strUrl, $intHttpStatus, $bTimeOut)
	{
		
	}
	
	
}
?>