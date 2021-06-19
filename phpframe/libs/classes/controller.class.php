<?php

/**
 * 控制器基类
 * @copyright Copyright (c) 2013-2023 chengpai.cc Inc. (http://www.chengpai.cc)
 * @author summerar
 */
class controller
{

    /**
     * 模板内使用的变量值
     */
    private $_vars = array();

    /**
     * 对模板赋值
     *
     * @param
     *            key 变量名称，或变量数组
     * @param
     *            value 变量值
     */
    public function assign($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $var => $val)
                if ($var != "")
                    $this->_vars[$var] = $val;
        } else {
            if ($key != "")
                $this->_vars[$key] = $value;
        }
    }

    /**
     * 输出模板
     *
     * @param unknown $tplname
     *            模板路径及名称
     * @param string $flag
     *            模板标识地址
     * @param string $output
     *            是否直接显示模板，设置成FALSE将返回HTML而不输出
     * @return string
     */
    public function display($tplname, $flag = null, $output = TRUE)
    {
      
        if (empty($flag)) {
            $tplname = APP_PATH . 'templates/' . $tplname;
        }
        $tplname .= '.php';
        @ob_start();
        if (is_readable($tplname)) {
            $tplpath = $tplname;
        } else {
            exit("无法找到模板 " . $tplname);
        }
        extract($this->_vars);
        include_once $tplpath;
        if (TRUE != $output) {
            return ob_get_clean();
        }
    }

    /**
     * 提示信息页面跳转，跳转地址如果传入数组，页面会提示多个地址供用户选择，默认跳转地址为数组的第一个值，时间为5秒。
     * showmessage('登录成功', array('默认跳转地址'=>'http://www.local'));
     *
     * @param string $msg
     *            提示信息
     * @param mixed(string/array) $url_forward
     *            跳转地址
     * @param int $ms
     *            跳转等待时间
     */
    function showmessage($msg, $url_forward = 'goback', $ms = 1250, $dialog = '', $returnjs = '')
    {
        $this->assign('msg', $msg);
        $this->assign('url_forward', $url_forward);
        $this->assign('ms', $ms);
        $this->display('message');
        exit();
    }
}

?>