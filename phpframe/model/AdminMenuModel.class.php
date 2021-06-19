<?php
pc_base::load_sys_class('BaseModel');

class AdminMenuModel extends BaseModel
{
	public function getAllMenu()
	{
		$temp=$this->_getMenu();
		$result=array();
		foreach($temp as $row)
		{
			if($row['parentid']==0)
			{
				$row['children']=array();
				$result[$row['id']]=$row;;
			}
			else
			{
				if(ROUTE_C==$row['c'])
				{
					$row['active']=1;
					$result[$row['parentid']]['in']=1;
				}
				array_push($result[$row['parentid']]['children'],$row);
			}
		}
		$result=array_values($result);
		return $result;
	}

	private function _getMenu()
	{
        $cache = pc_base::load_sys_class('cache_file');
		$key='menu_all';
		$result=$cache->get($key);
		if(!$result)
		{
			$result=$this->where(array('display'=>1))->select();
			$cache->set($key,$result);
		}
		return $result;
		
	}

}
