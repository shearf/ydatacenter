<?php
class CResult
{
	const RESULT_SUCESS = 1;
	const RESULT_FAIL = 0;
	
	public $failClass = 'fail';
	public $sucessClass = 'sucess';
	
	private $type;
	private $result;
	
	public function __construct($type, $result)
	{
		$this->type = $type;
		$this->result = $result;
	}
	
	public function getResult()
	{
		return $this->result;
	}
	
	public function getType()
	{
		return $this->type;
	}

	public function getResultClass()
	{
		return $this->type == self::RESULT_SUCESS ? $this->sucessClass : $this->failClass;
	}
}
?>