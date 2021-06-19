<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
import('@.libs.classes.model');
import('@.libs.classes.Page');

class BaseModel extends model
{
	protected $sql='';
	protected $options=array();

	public function getItemById($id) {
        return $this->where(array('order_id'=>$id))->find();
    }
	public function __construct($table_name='',$table_pre='')
	{
		$this->db_config = pc_base::load_config('database');
		//$this->db_setting = $db_setting;
		if($table_name=='')
			$this->table_name=$this->_getTableName();
		else
			$this->table_name=$table_name;
		parent::__construct();
		if($table_pre!='')
		{
			$this->db_tablepre=$table_pre;
			$this->table_name=$table_pre.$table_name;
		}
	}

	protected function _getTableName()
	{
		$name=substr(get_class($this),0,-5);
		$name=java2c($name);
		return $name;
	}

	public function table($table_name, $db_setting='')
	{
		if (empty($db_setting)) {
			$table_pre = $this->db_tablepre;
		} else {
			$table_pre = $this->db_config[$db_setting]['tablepre'];
		}
		$this->table_name=$table_pre.$table_name;
		return $this;
	}

	public function add($data=null)
	{
		if($data!=null)
			$this->options['data']=$data;

		$flag=$this->insert($this->options['data']);
		$this->options=array();
		$this->sql='';
		return $flag;
	}

	final public function select()
	{
		$this->_parseSql();

		$this->sql="select {$this->options['select']} from {$this->table_name} {$this->options['where']} {$this->options['order']} {$this->options['limit']}";
		$result=$this->query($this->sql);
		$this->options=array();
		$this->sql='';
		return $result;
	}

	final public function find()
	{
		$this->_parseSql();
		$this->sql="select {$this->options['select']} from {$this->table_name} {$this->options['where']} {$this->options['order']} limit 1";
		$result=$this->query($this->sql);
		$this->options=array();
		$this->sql='';
		return $result[0];
	}

	final public function getField($field=null)
	{
		if($filed!=null)
		$this->options['select']=$field;
		$this->_parseSql();

		$this->sql="select {$this->options['select']} from {$this->table_name} {$this->options['where']} {$this->options['order']} limit 1";
		$result=$this->query($this->sql);
		$this->options=array();
		$this->sql='';
		return $result[0][$field];
	}

	final public function count($where=null)
	{
		if($where!=null)
			$this->options['where']=$where;
		$this->_parseSql();

		//$this->sql="select count(*) as count from {$this->table_name} {$this->options['where']}";
		$this->sql="select count(*) as count from $where";
		$result=$this->query($this->sql);
		$this->options=array();
		$this->sql='';
		return $result[0]['count'];
	}
	final public function ecount($sql)
	{
		return $this->db->num_rows($sql);
	}

	final private function _save()
	{
		$this->_parseSql();
		$this->sql="update {$this->table_name} set {$this->options['data']} {$this->options['where']}";
		$result=$this->querySql($this->sql);
		$this->options=array();
		$this->sql='';
		return $result;
	}

	final public function save($data=null)
	{
		if($data!=null)
			$this->options['data']=$data;

		return $this->_save();
	}

	final public function setField($filed,$value)
	{
		$this->options['data']="`$filed`='$value'";

		return $this->_save();
	}

	final public function setDec($filed,$number=1)
	{
		$this->options['data']="`$filed`=`$filed`-$number";

		return $this->_save();
	}

	final public function setInc($filed,$number=1)
	{
		$this->options['data']="`$filed`=`$filed`+$number";

		return $this->_save();
	}


	final public function delete($where=null)
	{
		if($where!=null)
			$this->options['where']=$where;

		$this->_parseSql();
		$this->sql="delete from {$this->table_name} {$this->options['where']}";
		$result=$this->querySql($this->sql);
		$this->options=array();
		$this->sql='';
		return $result;
	}

	private function _parseSql()
	{

		if(isset($this->options['select']))
		{
			if(is_array($this->options['select']))
				$this->options['select']=implode(',',$this->options['select']);
		}
		else
			$this->options['select']='*';

		if(isset($this->options['where']))
		{
			if(is_array($this->options['where']))
			{
				$where='where ';
				foreach($this->options['where'] as $key=>$val)
				{
					$where.="`$key`='$val' and ";
				}
				$where=substr($where,0,strlen($where)-5);
				$this->options['where']=$where;
			}
			else
				$this->options['where']='where '.$this->options['where'];
		}
		else
			$this->options['where']='';

		if(isset($this->options['order']))
			$this->options['order']='order by '.$this->options['order'];
		else
			$this->options['order']='';

		if(isset($this->options['limit']))
			$this->options['limit']='limit '.$this->options['limit'];
		else
			$this->options['limit']='';

		if(isset($this->options['data']))
		{
			if(is_array($this->options['data']))
			{
				$data='';
				foreach($this->options['data'] as $key=>$val)
				{
					$data.="`$key`='$val',";
				}
				$this->options['data']=substr($data,0,strlen($data)-1);
			}

		}
		else
			$this->options['data']='';
	}


	final public function field($fields)
	{
		$this->options['select']=$fields;
		return $this;
	}

	final public function where($where)
	{
		$this->options['where']=$where;
		return $this;
	}

	final public function order($order)
	{
		$this->options['order']=$order;
		return $this;
	}

	final public function limit($limit)
	{
		$this->options['limit']=$limit;
		return $this;
	}

	final public function data($data)
	{
		$this->options['data']=$data;
		return $this;
	}

	public function query($sql)
	{
		$result=array();
		$this->querySql($sql);
		while($row=$this->db->fetch_next())
		{
			array_push($result,$row);
		}
		return $result;
	}
	public function queryone($sql)
	{
		$result=array();
		$str = $sql.' limit 1';
		$this->querySql($str);
		$row=$this->db->fetch_next();
		return $row;
	}
	public function equery($sql)
	{
		$result=array();
		@$redis = new Redis();
		$key = md5(md5($sql).date("YmdH"));
		if($redis->connect('127.0.0.1',6379)&&$redis->exists($key))
		{
			$redis->delete(md5(md5($sql).date("YmdH",time()-3600)));
			return unserialize($redis->get($key));
		}
		else
		{
			$this->querySql($sql);
			while($row=$this->db->fetch_next())
			{
				array_push($result,$row);
			}
			$redis->set($key,serialize($result));
			return $result;
		}

	}

	public function querySql($sql)
	{
		return $this->db->query($sql);
	}
}
