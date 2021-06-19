<?php
pc_base::load_sys_class('BaseModel');

class ConfigModel extends BaseModel
{
	private $_value;
	public function __construct()
	{
		parent::__construct();
		$this->_value=array();
	}
	
	public function getValue($key)
	{
		if($this->_value[$key])
			return $this->_value[$key];
		
		$value=$this->where(array('key'=>$key))->getField('value');
		return $value;
	}
}
