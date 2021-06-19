<?php

/**
 * db_pdo.class.php 数据库实现类
 *
 * @copyright Copyright (c) 2013-2023 chengpai.cc Inc. (http://www.chengpai.cc)
 * @author Summer Zhao
 * @version $id$
 *
 */
final class db_pdo extends PDO
{
    
    // pdo对象
    public $_pdo = null;

    public function __construct()
    {
        $config = pc_base::load_config('database', 'default');
        try {
            if ($config['pconnect']) {
                $this->_condition = array(
                    PDO::ATTR_PERSISTENT => true
                );
            }
            $this->_pdo = new PDO($config['type'] . ":dbname=" . $config['database'] . ";host=" . $config['hostname'], $config['username'], $config['password'], array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $config['charset']
            ));
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        return $this->_pdo;
    }

    public function getIntanse()
    {
        return $this->_pdo;
    }
}
?>