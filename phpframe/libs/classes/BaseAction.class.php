<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
$session_storage = 'session_' . pc_base::load_config('system', 'session_storage');
pc_base::load_sys_class($session_storage);

class BaseAction
{
	private $vals=array();

	public function __construct()
	{
		ini_set('date.timezone','Asia/Shanghai');
	}

	public function assign($key,$value)
	{
		$this->vals[$key]=$value;
	}

	public function display($file='',$output=true)
	{
		ob_start();
		foreach($this->vals as $key=>$val)
		{
			$$key=$val;
		}
		if($file=='')
		{
			$file_path=T(ROUTE_M,ROUTE_C,($file=='')?ROUTE_A:$file);
		}
		else
		{
			$file_path = './tpl/'.ROUTE_C.'/'.$file.'.php';
		}
		// if(!file_exists($file_path)&&$file!='')
		// {
		// 	$file_path=T(ROUTE_M,'public',$file);
		// }

		require_once($file_path);
		if(!$output) return ob_get_clean ();
	}

	public function displayJSON()
	{
		$vals=json_encode($this->vals);
		die($vals);
	}

	public function success($message,$url)
	{
		$this->showmessage($message,$url,'success');
	}

	public function error($message,$url)
	{
		$this->showmessage($message,$url,'danger');
	}

    public function showmessage($message, $url='', $code='message', $ms = 1250, $dialog = '', $returnjs = '')
    {
        $this->assign('message', $message);
	$this->assign('code',$code);
        $this->assign('url', $url);
        $this->assign('ms', $ms);
        $this->display('message');
    }

}
