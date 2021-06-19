<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
import('@.libs.classes.BaseAction');
pc_base::load_app_class('Http');

class ProtocolAction extends BaseAction
{
	protected $userInfo=array();
	protected $visitFrom='';
	protected $http;
	
	public function __construct()
	{
		session_start();
		
		$this->userInfo=array();
	}

	
	public function _upload($base64_image_content)
	{
		if(!$base64_image_content)
			$this->error(10000,'图片错误');
		
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result))
		{
			$type = $result[2];
			//文件类型检测
			$types=array(
				'jpg',
				'jpeg',
				'png',
				'gif',
			);
			$shorts=array(
				'jpeg'=>'jpg',
			);
			if(!in_array(strtolower($type),$types))
				$this->error(10010,'文件类型错误');

			if($shorts[$type])
				$type=$shorts[$type];
			
			pc_base::load_sys_func('dir');		
			$data=base64_decode(str_replace($result[1], '', $base64_image_content));
			$upload_root= pc_base::load_config('system','upload_path');
			$file_name=date('Ymdhis').rand(100, 999).'.'.$type;
			$upload_path=date('Y/md/');
			dir_create($upload_root.$upload_path);
			$flag=file_put_contents($upload_root.$upload_path.$file_name,$data);
			if(!$flag)
				$this->error(10020,'文件写入失败');
			
			$full_path=pc_base::load_config('system', 'upload_url').$upload_path.$file_name;
			return $full_path;
		}
		else
			$this->error(10000,'图片错误');
	
	}
	/**
	 * @param string  $sql  查询语句
	 * 执行查询语句
	 * @return array
	 */
	public final static function fetchSql($sql)
	{
		$rest_model = pc_base::load_model('rest_model');
		$result  = $rest_model->query($sql);
		$result = $rest_model->fetch_array($result);
		return $result;
	}
	/**
	 * @param string  $sql  查询语句
	 * 执行除查询语句外的语句
	 * @return array
	 */
	public final static function exeSql($sql)
	{
		$rest_model = pc_base::load_model('rest_model');
		$result  = $rest_model->query($sql);
		return $result;
	}
 
}
