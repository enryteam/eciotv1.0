<?php
/**
 *  dao.class.php dao数据模型基类
 *
 * @copyright			(C) 2013-2033 DNW 
 * @license				http://www.local/license/
 * @lastmodify			2015-6-7
 */
defined('IN_PHPFRAME') or exit('Access Denied');

class dao
{

    public $db;

    public function __construct()
    {
        $this->db = pc_base::load_sys_class("db_pdo")->getIntanse();
    }
}