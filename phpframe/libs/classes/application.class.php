<?php

/**
 *  application.class.php dnw应用程序创建类
 *
 * @copyright			(C) 2013-2033 DNW
 * @license				http://www.local/license/
 * @lastmodify			2015-6-7
 */
class application
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        $param = pc_base::load_sys_class('param');
        define('ROUTE_M', basename(APP_PATH));
        define('ROUTE_C', $param->route_c());
        define('ROUTE_A', $param->route_a());
        $this->init();
    }

    /**
     * 调用件事
     */
    private function init()
    {
        $controller = $this->load_controller();
        if (method_exists($controller, ROUTE_A)) {
            if (preg_match('/^[_]/i', ROUTE_A)) {
                exit('You are visiting the action is to protect the private action');
            } else {
                call_user_func(array(
                    $controller,
                    ROUTE_A
                ));
            }
        } else {
            header('HTTP/1.1 404 Not Found');
            header("status: 404 Not Found");
            exit;
        }
    }

    /**
     * 加载控制器
     *
     * @param string $filename
     * @param string $m
     * @return obj
     */
    private function load_controller($filename = '', $m = '')
    {
        if (empty($filename)) {
            $filename = ROUTE_C;
        }
        $filepath = APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . $filename . '.php';
        if (file_exists($filepath)) {
            $classname = $filename;
            include $filepath;
            if ($mypath = pc_base::my_path($filepath)) {
                $classname = 'MY_' . $filename;
                include $mypath;
            }
            if (class_exists($classname)) {
                return new $classname();
            } else {
              header('HTTP/1.1 404 Not Found');
              header("status: 404 Not Found");
              exit;
            }
        } else {
          header('HTTP/1.1 404 Not Found');
          header("status: 404 Not Found");
          exit;
        }
    }
}