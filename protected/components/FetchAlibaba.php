<?php
class FetchAlibaba extends CFetch
{
	public function __construct()
	{
		parent::__construct();
		parent::setRetry(5);
		$this->timed_out = 60;
		$this->setInputCharset("GBK");
		$this->setHttpHeaders(array(), "Mozilla/5.0 (X11; Linux i686; rv:2.0.1) Gecko/20100101 Firefox/4.0.1", "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8");
	}
	
}
?>