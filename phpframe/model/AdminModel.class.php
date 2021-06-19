<?php
pc_base::load_sys_class('BaseModel');

class AdminModel extends BaseModel
{
	//获得管理员信息
	//入口		$id		管理员主键
	//返回		$info
	public function getInfo($id)
	{
		return $this->where(array('id'=>$id))->find();
	}
	
	public function login($username,$password)
	{
		$result=array(
			'flag'=>false,
			'message'=>'',
		);
		
		$info=$this->where(array('username'=>$username))->find();
		if(!$info)
		{
			$result['message']='账户不存在';
			return $result;
		}
		if($info['password']!=md5(md5($password).$info['encrypt']))
		{
			$result['message']='密码错误';
			return $result;
		}

		//更新登录信息
		$data=array(
			"lastloginip"=>ip(),
			"lastlogintime"=>time(),
		);
		$this->where(array('userid'=>$info['userid']))->save($data);
		
		$_SESSION['uinfo']=array(
			'userid'=>$info['userid'],
			'username'=>$info['username'],
		);
		$result['flag']=true;
		return $result;
	}

	public function logout()
	{
		unset($_SESSION['uinfo']);
		return true;
	}
}
