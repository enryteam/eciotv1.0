<?php

/**
 *  global.func.php 公共函数库
 */

/**
 * 返回经addslashes处理过的字符串或数组
 *
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string) {
  if (!is_array($string))
    return addslashes($string);
  foreach ($string as $key => $val)
    $string[$key] = new_addslashes($val);
  return $string;
}

/**
 * 返回经stripslashes处理过的字符串或数组
 *
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
  if (!is_array($string))
    return stripslashes($string);
  foreach ($string as $key => $val)
    $string[$key] = new_stripslashes($val);
  return $string;
}

/**
 * 返回经htmlspecialchars处理过的字符串或数组
 *
 * @param $obj 需要处理的字符串或数组
 * @return mixed
 */
function new_html_special_chars($string) {
  $encoding = 'utf-8';
  if (strtolower(CHARSET) == 'gbk')
    $encoding = 'ISO-8859-15';
  if (!is_array($string))
    return htmlspecialchars($string, ENT_QUOTES, $encoding);
  foreach ($string as $key => $val)
    $string[$key] = new_html_special_chars($val);
  return $string;
}

function new_html_entity_decode($string) {
  $encoding = 'utf-8';
  if (strtolower(CHARSET) == 'gbk')
    $encoding = 'ISO-8859-15';
  return html_entity_decode($string, ENT_QUOTES, $encoding);
}

function new_htmlentities($string) {
  $encoding = 'utf-8';
  if (strtolower(CHARSET) == 'gbk')
    $encoding = 'ISO-8859-15';
  return htmlentities($string, ENT_QUOTES, $encoding);
}

/**
 * 安全过滤函数
 *
 * @param
 *            $string
 * @return string
 */
function safe_replace($string) {
  $string = str_replace('%20', '', $string);
  $string = str_replace('%27', '', $string);
  $string = str_replace('%2527', '', $string);
  $string = str_replace('*', '', $string);
  $string = str_replace('"', '&quot;', $string);
  $string = str_replace("'", '', $string);
  $string = str_replace('"', '', $string);
  $string = str_replace(';', '', $string);
  $string = str_replace('<', '&lt;', $string);
  $string = str_replace('>', '&gt;', $string);
  $string = str_replace("{", '', $string);
  $string = str_replace('}', '', $string);
  $string = str_replace('\\', '', $string);
  return $string;
}

/**
 * xss过滤函数
 *
 * @param
 *            $string
 * @return string
 */
function remove_xss($string) {
  $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string);

  $parm1 = Array(
    'javascript',
    'vbscript',
    'expression',
    'applet',
    'meta',
    'xml',
    'blink',
    'link',
    'script',
    'embed',
    'object',
    'iframe',
    'frame',
    'frameset',
    'ilayer',
    'layer',
    'bgsound',
    'title',
    'base'
  );

  $parm2 = Array(
    'onabort',
    'onactivate',
    'onafterprint',
    'onafterupdate',
    'onbeforeactivate',
    'onbeforecopy',
    'onbeforecut',
    'onbeforedeactivate',
    'onbeforeeditfocus',
    'onbeforepaste',
    'onbeforeprint',
    'onbeforeunload',
    'onbeforeupdate',
    'onblur',
    'onbounce',
    'oncellchange',
    'onchange',
    'onclick',
    'oncontextmenu',
    'oncontrolselect',
    'oncopy',
    'oncut',
    'ondataavailable',
    'ondatasetchanged',
    'ondatasetcomplete',
    'ondblclick',
    'ondeactivate',
    'ondrag',
    'ondragend',
    'ondragenter',
    'ondragleave',
    'ondragover',
    'ondragstart',
    'ondrop',
    'onerror',
    'onerrorupdate',
    'onfilterchange',
    'onfinish',
    'onfocus',
    'onfocusin',
    'onfocusout',
    'onhelp',
    'onkeydown',
    'onkeypress',
    'onkeyup',
    'onlayoutcomplete',
    'onload',
    'onlosecapture',
    'onmousedown',
    'onmouseenter',
    'onmouseleave',
    'onmousemove',
    'onmouseout',
    'onmouseover',
    'onmouseup',
    'onmousewheel',
    'onmove',
    'onmoveend',
    'onmovestart',
    'onpaste',
    'onpropertychange',
    'onreadystatechange',
    'onreset',
    'onresize',
    'onresizeend',
    'onresizestart',
    'onrowenter',
    'onrowexit',
    'onrowsdelete',
    'onrowsinserted',
    'onscroll',
    'onselect',
    'onselectionchange',
    'onselectstart',
    'onstart',
    'onstop',
    'onsubmit',
    'onunload'
  );

  $parm = array_merge($parm1, $parm2);

  for ($i = 0; $i < sizeof($parm); $i ++) {
    $pattern = '/';
    for ($j = 0; $j < strlen($parm[$i]); $j ++) {
      if ($j > 0) {
        $pattern .= '(';
        $pattern .= '(&#[x|X]0([9][a][b]);?)?';
        $pattern .= '|(&#0([9][10][13]);?)?';
        $pattern .= ')?';
      }
      $pattern .= $parm[$i][$j];
    }
    $pattern .= '/i';
    $string = preg_replace($pattern, ' ', $string);
  }
  return $string;
}

/**
 * 过滤ASCII码从0-28的控制字符
 *
 * @return String
 */
function trim_unsafe_control_chars($str) {
  $rule = '/[' . chr(1) . '-' . chr(8) . chr(11) . '-' . chr(12) . chr(14) . '-' . chr(31) . ']*/';
  return str_replace(chr(0), '', preg_replace($rule, '', $str));
}

/**
 * 格式化文本域内容
 *
 * @param $string 文本域内容
 * @return string
 */
function trim_textarea($string) {
  $string = nl2br(str_replace(' ', '&nbsp;', $string));
  return $string;
}

/**
 * 将文本格式成适合js输出的字符串
 *
 * @param string $string
 *            需要处理的字符串
 * @param intval $isjs
 *            是否执行字符串格式化，默认为执行
 * @return string 处理后的字符串
 */
function format_js($string, $isjs = 1) {
  $string = addslashes(str_replace(array(
    "\r",
    "\n",
    "\t"
      ), array(
    '',
    '',
    ''
      ), $string));
  return $isjs ? 'document.write("' . $string . '");' : $string;
}

/**
 * 转义 javascript 代码标记
 *
 * @param
 *            $str
 * @return mixed
 */
function trim_script($str) {
  if (is_array($str)) {
    foreach ($str as $key => $val) {
      $str[$key] = trim_script($val);
    }
  } else {
    $str = preg_replace('/\<([\/]?)script([^\>]*?)\>/si', '&lt;\\1script\\2&gt;', $str);
    $str = preg_replace('/\<([\/]?)iframe([^\>]*?)\>/si', '&lt;\\1iframe\\2&gt;', $str);
    $str = preg_replace('/\<([\/]?)frame([^\>]*?)\>/si', '&lt;\\1frame\\2&gt;', $str);
    $str = str_replace('javascript:', 'javascript：', $str);
  }
  return $str;
}

/**
 * 获取当前页面完整URL地址
 */
function get_url() {
  $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
  $php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
  $path_info = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
  $relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . safe_replace($_SERVER['QUERY_STRING']) : $path_info);
  return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

/**
 * 字符截取 支持UTF8/GBK
 *
 * @param
 *            $string
 * @param
 *            $length
 * @param
 *            $dot
 */
function str_cut($string, $length, $dot = '...') {
  $strlen = strlen($string);
  if ($strlen <= $length)
    return $string;
  $string = str_replace(array(
    ' ',
    '&nbsp;',
    '&amp;',
    '&quot;',
    '&#039;',
    '&ldquo;',
    '&rdquo;',
    '&mdash;',
    '&lt;',
    '&gt;',
    '&middot;',
    '&hellip;'
    ), array(
    '∵',
    ' ',
    '&',
    '"',
    "'",
    '“',
    '”',
    '—',
    '<',
    '>',
    '·',
    '…'
    ), $string);
  $strcut = '';
  if (strtolower(CHARSET) == 'utf-8') {
    $length = intval($length - strlen($dot) - $length / 3);
    $n = $tn = $noc = 0;
    while ($n < strlen($string)) {
      $t = ord($string[$n]);
      if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
        $tn = 1;
        $n ++;
        $noc ++;
      } elseif (194 <= $t && $t <= 223) {
        $tn = 2;
        $n += 2;
        $noc += 2;
      } elseif (224 <= $t && $t <= 239) {
        $tn = 3;
        $n += 3;
        $noc += 2;
      } elseif (240 <= $t && $t <= 247) {
        $tn = 4;
        $n += 4;
        $noc += 2;
      } elseif (248 <= $t && $t <= 251) {
        $tn = 5;
        $n += 5;
        $noc += 2;
      } elseif ($t == 252 || $t == 253) {
        $tn = 6;
        $n += 6;
        $noc += 2;
      } else {
        $n ++;
      }
      if ($noc >= $length) {
        break;
      }
    }
    if ($noc > $length) {
      $n -= $tn;
    }
    $strcut = substr($string, 0, $n);
    $strcut = str_replace(array(
      '∵',
      '&',
      '"',
      "'",
      '“',
      '”',
      '—',
      '<',
      '>',
      '·',
      '…'
      ), array(
      ' ',
      '&amp;',
      '&quot;',
      '&#039;',
      '&ldquo;',
      '&rdquo;',
      '&mdash;',
      '&lt;',
      '&gt;',
      '&middot;',
      '&hellip;'
      ), $strcut);
  } else {
    $dotlen = strlen($dot);
    $maxi = $length - $dotlen - 1;
    $current_str = '';
    $search_arr = array(
      '&',
      ' ',
      '"',
      "'",
      '“',
      '”',
      '—',
      '<',
      '>',
      '·',
      '…',
      '∵'
    );
    $replace_arr = array(
      '&amp;',
      '&nbsp;',
      '&quot;',
      '&#039;',
      '&ldquo;',
      '&rdquo;',
      '&mdash;',
      '&lt;',
      '&gt;',
      '&middot;',
      '&hellip;',
      ' '
    );
    $search_flip = array_flip($search_arr);
    for ($i = 0; $i < $maxi; $i ++) {
      $current_str = ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
      if (in_array($current_str, $search_arr)) {
        $key = $search_flip[$current_str];
        $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
      }
      $strcut .= $current_str;
    }
  }
  return $strcut . $dot;
}

/**
 * 获取请求ip
 *
 * @return ip地址
 */
function ip() {
  if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
    $ip = getenv('HTTP_CLIENT_IP');
  } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
    $ip = getenv('HTTP_X_FORWARDED_FOR');
  } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
    $ip = getenv('REMOTE_ADDR');
  } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';
}

function get_cost_time() {
  $microtime = microtime(TRUE);
  return $microtime - SYS_START_TIME;
}

/**
 * 程序执行时间
 *
 * @return int
 */
function execute_time() {
  $stime = explode(' ', SYS_START_TIME);
  $etime = explode(' ', microtime());
  return number_format(($etime[1] + $etime[0] - $stime[1] - $stime[0]), 6);
}

/**
 * 产生随机字符串
 *
 * @param int $length
 *            输出长度
 * @param string $chars
 *            可选的 ，默认为 0123456789
 * @return string 字符串
 *
 */
function random($length, $chars = '0123456789') {
  $hash = '';
  $max = strlen($chars) - 1;
  for ($i = 0; $i < $length; $i ++) {
    $hash .= $chars[mt_rand(0, $max)];
  }
  return $hash;
}

/**
 * 将字符串转换为数组
 *
 * @param string $data
 * @return array
 *
 */
function string2array($data) {
  if ($data == '')
    return array();
  @eval("\$array = $data;");
  return $array;
}

/**
 * 将数组转换为字符串
 *
 * @param array $data
 * @param bool $isformdata
 * @return string
 *
 */
function array2string($data, $isformdata = 1) {
  if ($data == '')
    return '';
  if ($isformdata)
    $data = new_stripslashes($data);
  return addslashes(var_export($data, TRUE));
}

/**
 * 转换字节数为其他单位
 *
 *
 * @param string $filesize
 * @return string
 *
 */
function sizecount($filesize) {
  if ($filesize >= 1073741824) {
    $filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
  } elseif ($filesize >= 1048576) {
    $filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
  } elseif ($filesize >= 1024) {
    $filesize = round($filesize / 1024 * 100) / 100 . ' KB';
  } else {
    $filesize = $filesize . ' Bytes';
  }
  return $filesize;
}

/**
 * 字符串加密、解密函数
 *
 *
 * @param string $txt
 * @param string $operation
 * @param string $key
 * @param string $expiry
 * @return string
 *
 */
function sys_auth($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
  $key_length = 4;
  $key = md5($key != '' ? $key : pc_base::load_config('system', 'auth_key'));
  $fixedkey = md5($key);
  $egiskeys = md5(substr($fixedkey, 16, 16));
  $runtokey = $key_length ? ($operation == 'ENCODE' ? substr(md5(microtime(true)), - $key_length) : substr($string, 0, $key_length)) : '';
  $keys = md5(substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
  $string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));

  $i = 0;
  $result = '';
  $string_length = strlen($string);
  for ($i = 0; $i < $string_length; $i ++) {
    $result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));
  }
  if ($operation == 'ENCODE') {
    return $runtokey . str_replace('=', '', base64_encode($result));
  } else {
    if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $egiskeys), 0, 16)) {
      return substr($result, 26);
    } else {
      return '';
    }
  }
}

/**
 * 语言文件处理
 *
 * @param string $language
 * @param array $pars
 * @param string $modules
 * @return string
 *
 */
function L($language = 'no_language', $pars = array(), $modules = '') {
  static $LANG = array();
  static $LANG_MODULES = array();
  static $lang = '';
  if (defined('IN_ADMIN')) {
    $lang = SYS_STYLE ? SYS_STYLE : 'zh-cn';
  } else {
    $lang = pc_base::load_config('system', 'lang');
  }
  if (!$LANG) {
    require_once PC_PATH . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . 'system.lang.php';
    if (defined('IN_ADMIN'))
      require_once PC_PATH . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . 'system_menu.lang.php';
    if (file_exists(PC_PATH . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . ROUTE_M . '.lang.php'))
      require_once PC_PATH . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . ROUTE_M . '.lang.php';
  }
  if (!empty($modules)) {
    $modules = explode(',', $modules);
    foreach ($modules as $m) {
      if (!isset($LANG_MODULES[$m]))
        require_once PC_PATH . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . $m . '.lang.php';
    }
  }
  if (!array_key_exists($language, $LANG)) {
    return $language;
  } else {
    $language = $LANG[$language];
    if ($pars) {
      foreach ($pars as $_k => $_v) {
        $language = str_replace('{' . $_k . '}', $_v, $language);
      }
    }
    return $language;
  }
}

/**
 * 模板调用
 *
 * @param
 *            $module
 * @param
 *            $template
 * @param
 *            $istag
 * @return unknown_type
 */
function template($template = 'index', $style = '') {

  if (file_exists(APP_PATH . 'templates' . DIRECTORY_SEPARATOR . $template . '.php')) {
    include_once APP_PATH . 'templates' . DIRECTORY_SEPARATOR . $template . '.php';
  } else {
    echo 'template ' . $template . 'not exist;';
  }
}

/**
 * 输出自定义错误
 *
 * @param $errno 错误号
 * @param $errstr 错误描述
 * @param $errfile 报错文件地址
 * @param $errline 错误行号
 * @return string 错误提示
 */
function my_error_handler($errno, $errstr, $errfile, $errline) {
  if ($errno == 8)
    return '';
  $errfile = str_replace(PHPFRAME_PATH, '', $errfile);
  if (pc_base::load_config('system', 'errorlog')) {
    php4log('ERROR', date('m-d H:i:s', SYS_TIME) . ' | ' . $errno . ' | ' . str_pad($errstr, 30) . ' | ' . $errfile . ' | ' . $errline . "\n ");
  } else {

    $str = '<div style="font-size:12px;text-align:left; border-bottom:1px solid #9cc9e0; border-right:1px solid #9cc9e0;padding:1px 4px;color:#000000;font-family:Arial, Helvetica,sans-serif;"><span>errorno:' . $errno . ',str:' . $errstr . ',file:<font color="blue">' . $errfile . '</font>,line' . $errline . '</span></div>';
    echo $str;
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
function showmessage($msg, $url_forward = 'goback', $ms = 1250, $dialog = '', $returnjs = '') {
  if (defined('IN_ADMIN')) {
    include (admin::admin_tpl('showmessage', 'admin'));
  } else {
    include template('message');
  }
  exit();
}

/**
 * 查询字符是否存在于某字符串
 *
 * @param $haystack 字符串
 * @param $needle 要查找的字符
 * @return bool
 */
function str_exists($haystack, $needle) {
  return !(strpos($haystack, $needle) === FALSE);
}

/**
 * 取得文件扩展
 *
 * @param $filename 文件名
 * @return 扩展名
 */
function fileext($filename) {
  return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}

/**
 * 加载模板标签缓存
 *
 * @param string $name
 *            缓存名
 * @param integer $times
 *            缓存时间
 */
function tpl_cache($name, $times = 0) {
  $filepath = 'tpl_data';
  $info = getcacheinfo($name, $filepath);
  if (SYS_TIME - $info['filemtime'] >= $times) {
    return false;
  } else {
    return getcache($name, $filepath);
  }
}

/**
 * 写入缓存，默认为文件缓存，不加载缓存配置。
 *
 * @param $name 缓存名称
 * @param $data 缓存数据
 * @param $filepath 数据路径（模块名称）
 *            caches/cache_$filepath/
 * @param $type 缓存类型[file,memcache,apc]
 * @param $config 配置名称
 * @param $timeout 过期时间
 */
function setcache($name, $data, $filepath = '', $type = 'file', $config = '', $timeout = 0) {
  pc_base::load_sys_class('cache_factory', '', 0);
  if ($config) {
    $cacheconfig = pc_base::load_config('cache');
    $cache = cache_factory::get_instance($cacheconfig)->get_cache($config);
  } else {
    $cache = cache_factory::get_instance()->get_cache($type);
  }

  return $cache->set($name, $data, $timeout, '', $filepath);
}

/**
 * 读取缓存，默认为文件缓存，不加载缓存配置。
 *
 * @param string $name
 *            缓存名称
 * @param $filepath 数据路径（模块名称）
 *            caches/cache_$filepath/
 * @param string $config
 *            配置名称
 */
function getcache($name, $filepath = '', $type = 'file', $config = '') {
  pc_base::load_sys_class('cache_factory', '', 0);
  if ($config) {
    $cacheconfig = pc_base::load_config('cache');
    $cache = cache_factory::get_instance($cacheconfig)->get_cache($config);
  } else {
    $cache = cache_factory::get_instance()->get_cache($type);
  }
  return $cache->get($name, '', '', $filepath);
}

/**
 * 删除缓存，默认为文件缓存，不加载缓存配置。
 *
 * @param $name 缓存名称
 * @param $filepath 数据路径（模块名称）
 *            caches/cache_$filepath/
 * @param $type 缓存类型[file,memcache,apc]
 * @param $config 配置名称
 */
function delcache($name, $filepath = '', $type = 'file', $config = '') {
  pc_base::load_sys_class('cache_factory', '', 0);
  if ($config) {
    $cacheconfig = pc_base::load_config('cache');
    $cache = cache_factory::get_instance($cacheconfig)->get_cache($config);
  } else {
    $cache = cache_factory::get_instance()->get_cache($type);
  }
  return $cache->delete($name, '', '', $filepath);
}

/**
 * 读取缓存，默认为文件缓存，不加载缓存配置。
 *
 * @param string $name
 *            缓存名称
 * @param $filepath 数据路径（模块名称）
 *            caches/cache_$filepath/
 * @param string $config
 *            配置名称
 */
function getcacheinfo($name, $filepath = '', $type = 'file', $config = '') {
  pc_base::load_sys_class('cache_factory');
  if ($config) {
    $cacheconfig = pc_base::load_config('cache');
    $cache = cache_factory::get_instance($cacheconfig)->get_cache($config);
  } else {
    $cache = cache_factory::get_instance()->get_cache($type);
  }
  return $cache->cacheinfo($name, '', '', $filepath);
}

/**
 * 生成sql语句，如果传入$in_cloumn 生成格式为 IN('a', 'b', 'c')
 *
 * @param $data 条件数组或者字符串
 * @param $front 连接符
 * @param $in_column 字段名称
 * @return string
 */
function to_sqls($data, $front = ' AND ', $in_column = false) {
  if ($in_column && is_array($data)) {
    $ids = '\'' . implode('\',\'', $data) . '\'';
    $sql = "$in_column IN ($ids)";
    return $sql;
  } else {
    if ($front == '') {
      $front = ' AND ';
    }
    if (is_array($data) && count($data) > 0) {
      $sql = '';
      foreach ($data as $key => $val) {
        $sql .= $sql ? " $front `$key` = '$val' " : " `$key` = '$val' ";
      }
      return $sql;
    } else {
      return $data;
    }
  }
}

/**
 * 分页函数
 *
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $perpage 每页显示数
 * @param $urlrule URL规则
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 分页
 */
function pages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(), $setpages = 10) {
  if (defined('URLRULE') && $urlrule == '') {
    $urlrule = URLRULE;
    $array = $GLOBALS['URL_ARRAY'];
  } elseif ($urlrule == '') {
    $urlrule = url_par('page={$page}');
  }
  $multipage = '';
  if ($num > $perpage) {
    $page = $setpages + 1;
    $offset = ceil($setpages / 2 - 1);
    $pages = ceil($num / $perpage);
    if (defined('IN_ADMIN') && !defined('PAGES'))
      define('PAGES', $pages);
    $from = $curr_page - $offset;
    $to = $curr_page + $offset;
    $more = 0;
    if ($page >= $pages) {
      $from = 2;
      $to = $pages - 1;
    } else {
      if ($from <= 1) {
        $to = $page - 1;
        $from = 2;
      } elseif ($to >= $pages) {
        $from = $pages - ($page - 2);
        $to = $pages - 1;
      }
      $more = 1;
    }
    if ($curr_page > 0) {
      if ($curr_page == 1) {
        $multipage .= ' <a href="javascript:;" style="margin-left:10px;" class="crm-pages"><</a><a href="javascript:;" style="margin-left:10px;" class="crm-pages active">1</a>';
      } elseif ($curr_page > 6 && $more) {
        $multipage .= " <a href='" . pageurl($urlrule, $curr_page - 1, $array) . "' style='margin-left:10px;' class='crm-pages'><</a>  <a href='" . pageurl($urlrule, 1, $array) . "' class='crm-pages ' >1</a>  <a href='javascript:;'>...</a>";
      } else {
        $multipage .= " <a href='" . pageurl($urlrule, $curr_page - 1, $array) . "' style='margin-left:20px;' class='crm-pages'><</a>  <a href='" . pageurl($urlrule, 1, $array) . "' style='margin-left:10px;' class='crm-pages ' >1</a> ";
      }
    }
    for ($i = $from; $i <= $to; $i ++) {
      if ($i != $curr_page) {
        $multipage .= " <a href='" . pageurl($urlrule, $i, $array) . "' style='margin-left:5px;' class='crm-pages '>" . $i . "</a>";
      } else {
        $multipage .= " <a href='javascript:;' style='margin-left:5px;' class='crm-pages active'>" . $i . "</a>";
      }
    }


    if ($curr_page < $pages) {

      if ($curr_page < $pages - 5 && $more) {

        $multipage .= "<a href='javascript:;'>...</a><a href='" . pageurl($urlrule, $pages, $array) . "' style='margin-left:5px;' class='crm-pages'>" . $pages . "</a><a href='" . pageurl($urlrule, $curr_page + 1, $array) . "' style='margin-left:5px;' class='crm-pages'>></a>";
      } else {

        $multipage .= " <a href='" . pageurl($urlrule, $pages, $array) . "' style='margin-left:5px;'  class='crm-pages '>" . $pages . "</a>  <a href='" . pageurl($urlrule, $curr_page + 1, $array) . "' style='margin-left:5px;' class='crm-pages'>></a> ";
      }
    } elseif ($curr_page == $pages) {
      $multipage .= "  <a href='javascript:;' style='margin-left:5px;' class='crm-pages active'>" . $pages . "</a> <a href='javascript:;' style='margin-left:5px;' class='crm-pages'>></a> ";
    } else {
      $multipage .= " <a href='" . pageurl($urlrule, $pages, $array) . "' style='margin-left:5px;' class='crm-pages'>" . $pages . "</a>  <a href='" . pageurl($urlrule, $curr_page + 1, $array) . "' style='margin-left:5px;' class='crm-pages'>></a> ";
    }
  }
  $multipage = "<span href='###' class='crm-pages' style='font-size:15px;'>共<span style='margin-left:5px;'>" . $num . "</span><span style='margin-left:5px;'>条</span><span style='margin-left:5px;'>" . $multipage . "</span>";
  return $multipage;
}

//BMS分页
function pages_bms($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(), $setpages = 10) {
  $urlrule = url_par('page={$page}');
  $multipage = '';
  if ($num > $perpage) {
    $page = $setpages + 1;
    $offset = ceil($setpages / 2 - 1);
    $pages = ceil($num / $perpage);
    if (defined('IN_ADMIN') && !defined('PAGES'))
      define('PAGES', $pages);
    $from = $curr_page - $offset;
    $to = $curr_page + $offset;
    $more = 0;
    if ($page >= $pages) {
      $from = 2;
      $to = $pages - 1;
    } else {
      if ($from <= 1) {
        $to = $page - 1;
        $from = 2;
      } elseif ($to >= $pages) {
        $from = $pages - ($page - 2);
        $to = $pages - 1;
      }
      $more = 1;
    }
    if ($curr_page > 0) {
      if ($curr_page == 1) {
        $multipage .= "<li><a href='javascript:'><i class='fa fa-chevron-left'></i></a></li><li><a href='javascript:' style='background:#108ee9;color:white;'>1</a></li>";
      } elseif ($curr_page > 6 && $more) {
        $multipage .= "<li><a href='" . pageurl($urlrule, $curr_page - 1, $array) . "'><i class='fa fa-chevron-left'></i></a></li><li><a href='" . pageurl($urlrule, 1, $array) . "'>1</a></li><li><a href='javascript'>...</a></li>";
      } else {
        $multipage .= "<li><a href='" . pageurl($urlrule, $curr_page - 1, $array) . "'><i class='fa fa-chevron-left'></i></a></li><li><a href='" . pageurl($urlrule, 1, $array) . "'>1</a></li>";
      }
    }
    for ($i = $from; $i <= $to; $i ++) {
      if ($i != $curr_page) {
        $multipage .= "<li><a href='" . pageurl($urlrule, $i, $array) . "'>" . $i . "</a></li>";
      } else {
        $multipage .= "<li><a href='" . pageurl($urlrule, $i, $array) . "' style='background:#108ee9;color:white;'>" . $i . "</a></li>";
      }
    }
    if ($curr_page < $pages) {
      if ($curr_page < $pages - 5 && $more) {
        $multipage .= "<li><a href='##' >...</a></li><li><a href='" . pageurl($urlrule, $pages, $array) . "'>" . $pages . "</a></li><li><a href='" . pageurl($urlrule, $curr_page + 1, $array) . "'><i class='fa fa-chevron-right'></i></a></li>";
      } else {
        $multipage .= '<li><a href="' . pageurl($urlrule, $pages, $array) . '">' . $pages . '</a></li><li><a style="border-right:1px solid #cccccc;" href="' . pageurl($urlrule, $curr_page + 1, $array) . '"><i class="fa fa-chevron-right"></i></a></li>';
      }
    } elseif ($curr_page == $pages) {
      $multipage .= "<li><a href='javascript:;' style='background:#108ee9;color:white;'>" . $pages . "</a></li><li><a href='javascript:;' ><i class='fa fa-chevron-right'></i></a></li>";
    } else {
      $multipage .= "<li><a href='" . pageurl($urlrule, $pages, $array) . "'>" . $pages . "</a></li><li><a href='" . pageurl($urlrule, $curr_page + 1, $array) . "'><i class='fa fa-chevron-right'></i></a></li>";
    }
  }
  if (!$num)
    $num = 0;
  $multipage = "<div class='row'><div class='col-sm-4 hidden-xs' style='color:#1E90FF;'>共&nbsp;" . $num . "&nbsp;条记录</div><div class='col-sm-4 text-center'></div><div class='col-sm-4 text-right text-center-xs'><ul class='pagination pagination-sm m-t-none m-b-none'>" . $multipage . "</ul></div></div>";
  return $multipage;
}

//erp分页
function pages_layer($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(), $setpages = 6) {
  if (defined('URLRULE') && $urlrule == '') {
    $urlrule = URLRULE;
    $array = $GLOBALS['URL_ARRAY'];
  } elseif ($urlrule == '') {
    $urlrule = url_par('page={$page}');
  }

  $multipage = "<div class='layui-box layui-laypage layui-laypage-default' id='layui-laypage-" . $curr_page . "'>" . $multipage . "";
  if ($num > $perpage) {
    $page = $setpages + 1;
    $offset = ceil($setpages / 2 - 1);
    $pages = ceil($num / $perpage);
    if (defined('IN_ADMIN') && !defined('PAGES'))
      define('PAGES', $pages);
    $from = $curr_page - $offset;
    $to = $curr_page + $offset;
    $more = 0;
    if ($page >= $pages) {
      $from = 2;
      $to = $pages - 1;
    } else {
      if ($from <= 1) {
        $to = $page - 1;
        $from = 2;
      } elseif ($to >= $pages) {
        $from = $pages - ($page - 2);
        $to = $pages - 1;
      }
      $more = 1;
    }
    if ($curr_page > 0) {
      if ($curr_page == 1) {
        $multipage .= '<a href="javascript:;" class="layui-laypage-prev layui-disabled" data-page="4"><i class="layui-icon"></i></a><span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>1</em></span>';
      } elseif ($curr_page > 6 && $more) {
        $multipage .= '<a href="' . pageurl($urlrule, $curr_page - 1, $array) . '" class="layui-laypage-prev" data-page="4"><i class="layui-icon"></i></a><a href="' . pageurl($urlrule, 1, $array) . '" class="layui-laypage-first" data-page="1" title="首页">1</a><span class="layui-laypage-spr">…</span>';
      } else {
        $multipage .= '<a href="' . pageurl($urlrule, $curr_page - 1, $array) . '" class="layui-laypage-prev" data-page="4"><i class="layui-icon"></i></a><a href="' . pageurl($urlrule, 1, $array) . '" class="layui-laypage-first" data-page="1" title="首页">1</a>';
      }
    }
    for ($i = $from; $i <= $to; $i ++) {
      if ($i != $curr_page) {
        $multipage .= '<a href="' . pageurl($urlrule, $i, $array) . '" data-page="' . $i . '">' . $i . '</a>';
      } else {
        $multipage .= '<span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>' . $i . '</em></span>';
      }
    }
    if ($curr_page < $pages) {
      if ($curr_page < $pages - 5 && $more) {
        $multipage .= '<span class="layui-laypage-spr">…</span><a href="' . pageurl($urlrule, $pages, $array) . '" style="color:black">' . $pages . '</a><a href="' . pageurl($urlrule, $curr_page + 1, $array) . '" class="layui-laypage-next" data-page="' . ($curr_page + 1) . '"> <i class="layui-icon"></i></a>';
      } else {
        $multipage .= '<a href="' . pageurl($urlrule, $pages, $array) . '" style="color:black">' . $pages . '</a><a href="' . pageurl($urlrule, $curr_page + 1, $array) . '" class="layui-laypage-next" data-page="' . ($curr_page + 1) . '"> <i class="layui-icon"></i></a> ';
      }
    } elseif ($curr_page == $pages) {
      $multipage .= '<span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>' . $curr_page . '</em></span><a href="javascript:;" class="layui-laypage-next layui-disabled" data-page="' . ($curr_page + 1) . '"> <i class="layui-icon"></i></a> ';
    } else {
      $multipage .= '<a href="' . pageurl($urlrule, $pages, $array) . '" style="color:black">' . $pages . '</a><a href="' . pageurl($urlrule, $curr_page + 1, $array) . '" class="layui-laypage-next" data-page="' . ($curr_page + 1) . '"> <i class="layui-icon"></i></a>';
    }
  }
  //$multipage .='<span class="layui-laypage-skip">到第<input type="text" min="1" value="' . $curr_page . '" class="layui-input">页<button type="button" class="layui-laypage-btn">确定</button></span>';
  
  $multipage .='<span class="layui-laypage-count">共 ' . $num . ' 条</span>
                              <span class="layui-laypage-limits"><select lay-ignore="" class=" choose_pageSize" onchange="choose_pageSize()" >';
  if ($_SESSION["pageSize"] == 10) {
    $multipage .='<option value="10" selected>10 条/页</option>';
  } else {
    $multipage .='<option value="10" >10 条/页</option>';
  }
  if ($_SESSION["pageSize"] == 15) {
    $multipage .='<option value="15" selected>15 条/页</option>';
  } else {
    $multipage .='<option value="15" >15 条/页</option>';
  }
  if ($_SESSION["pageSize"] == 20) {
    $multipage .='<option value="20" selected>20 条/页</option>';
  } else {
    $multipage .='<option value="20" >20 条/页</option>';
  }
  if ($_SESSION["pageSize"] == 25) {
    $multipage .='<option value="25" selected>25 条/页</option>';
  } else {
    $multipage .='<option value="25" >25 条/页</option>';
  }
  if ($_SESSION["pageSize"] == 30) {
    $multipage .='<option value="30" selected>30 条/页</option>';
  } else {
    $multipage .='<option value="30" >30 条/页</option>';
  }
  $multipage .='</select></span>';
  if ($num > 10) {
    return $multipage;
  }
}


/**
 * 分页函数
 *
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $perpage 每页显示数
 * @param $urlrule URL规则
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 分页
 */
function _pages($num, $curr_page, $perpage = 5, $urlrule = '', $array = array()) {
  if (defined('URLRULE') && $urlrule == '') {
    $urlrule = URLRULE;
    $array = $GLOBALS['URL_ARRAY'];
  } elseif ($urlrule == '') {
    $urlrule = url_par('page={$page}');
  }
  $multipage = '';
  $num = max(intval($num), 1);
  $pages = ceil($num / $perpage);
  if ($curr_page > $pages) {
    $curr_page = $pages;
  }
  if ($curr_page == 1) {
    $pre = 1;
  } else {
    $pre = $curr_page - 1;
  }
  if ($pages == 1) {
    $next = 1;
  } else
  if ($curr_page < $pages) {
    $next = $curr_page + 1;
  } else {
    $next = $pages;
  }

  $multipage .= '<p class="v2_left">' . $curr_page . '/' . $pages . '</p>';
  $multipage .= ' <a href="' . pageurl($urlrule, 1, $array) . '" class="v2_left">首页</a>';
  $multipage .= ' <a href="' . pageurl($urlrule, $pre, $array) . '" class="v2_left">上一页</a>';
  $multipage .= ' <a href="' . pageurl($urlrule, $next, $array) . '" class="v2_left">下一页</a>';
  $multipage .= ' <a href="' . pageurl($urlrule, $pages, $array) . '" class="v2_left">尾页</a>';
  return $multipage;
}

/**
 * 数组分页函数 核心函数 array_slice
 * 用此函数之前要先将数据库里面的所有数据按一定的顺序查询出来存入数组中
 * $count 每页多少条数据
 * $page 当前第几页
 * $array 查询出来的所有数组
 * order 0 - 不变 1- 反序
 */
function page_array($count, $page, $array) {
  $page = (empty($page)) ? '1' : $page; // 判断当前页面是否为空 如果为空就表示为第一页面
  $start = ($page - 1) * $count; // 计算每次分页的开始位置
  $totals = count($array);
  $countpage = ceil($totals / $count); // 计算总页面数
  $pagedata = array();
  $pagedata = array_slice($array, $start, $count);
  return $pagedata; // 返回查询数据
}

/**
 * 返回分页路径
 *
 * @param $urlrule 分页规则
 * @param $page 当前页
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 完整的URL路径
 */
function pageurl($urlrule, $page, $array = array()) {
  if (strpos($urlrule, '~')) {
    $urlrules = explode('~', $urlrule);
    $urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
  }
  $findme = array(
    '{$page}'
  );
  $replaceme = array(
    $page
  );
  if (is_array($array))
    foreach ($array as $k => $v) {
      $varchar .="&" . $k . "=" . $v;
    }
  $url = str_replace($findme, $replaceme, $urlrule) . $varchar;
  return $url;
}

/**
 * URL路径解析，pages 函数的辅助函数
 *
 * @param $par 传入需要解析的变量
 *            默认为，page={$page}
 * @param $url URL地址
 * @return URL
 */
function url_par($par, $url = '') {
  if ($url == '')
    $url = get_url();
  $pos = strpos($url, '?');
  if ($pos === false) {
    $url .= '?' . $par;
  } else {
    $querystring = substr(strstr($url, '?'), 1);
    parse_str($querystring, $pars);
    $query_array = array();
    foreach ($pars as $k => $v) {
      if ($k != 'page')
        $query_array[$k] = $v;
    }
    $querystring = http_build_query($query_array) . '&' . $par;
    $url = substr($url, 0, $pos) . '?' . $querystring;
  }
  return $url;
}

/**
 * 判断email格式是否正确
 *
 * @param
 *            $email
 */
function is_email($email) {
  return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

/**
 * iconv 编辑转换
 */
if (!function_exists('iconv')) {

  function iconv($in_charset, $out_charset, $str) {
    $in_charset = strtoupper($in_charset);
    $out_charset = strtoupper($out_charset);
    if (function_exists('mb_convert_encoding')) {
      return mb_convert_encoding($str, $out_charset, $in_charset);
    } else {
      pc_base::load_sys_func('iconv');
      $in_charset = strtoupper($in_charset);
      $out_charset = strtoupper($out_charset);
      if ($in_charset == 'UTF-8' && ($out_charset == 'GBK' || $out_charset == 'GB2312')) {
        return utf8_to_gbk($str);
      }
      if (($in_charset == 'GBK' || $in_charset == 'GB2312') && $out_charset == 'UTF-8') {
        return gbk_to_utf8($str);
      }
      return $str;
    }
  }

}

/**
 * 代码广告展示函数
 *
 * @param intval $siteid
 *            所属站点
 * @param intval $id
 *            广告ID
 * @return 返回广告代码
 */
function show_ad($siteid, $id) {
  $siteid = intval($siteid);
  $id = intval($id);
  if (!$id || !$siteid)
    return false;
  $p = pc_base::load_model('poster_model');
  $r = $p->get_one(array(
    'spaceid' => $id,
    'siteid' => $siteid
    ), 'disabled, setting', '`id` ASC');
  if ($r['disabled'])
    return '';
  if ($r['setting']) {
    $c = string2array($r['setting']);
  } else {
    $r['code'] = '';
  }
  return $c['code'];
}

/**
 * 获取当前的站点ID
 */
function get_siteid() {
  static $siteid;
  if (!empty($siteid))
    return $siteid;
  if (defined('IN_ADMIN')) {
    if ($d = param::get_cookie('siteid')) {
      $siteid = $d;
    } else {
      return '';
    }
  } else {
    $data = getcache('sitelist', 'commons');
    if (!is_array($data))
      return '1';
    $site_url = SITE_PROTOCOL . SITE_URL;
    foreach ($data as $v) {
      if ($v['url'] == $site_url . '/')
        $siteid = $v['siteid'];
    }
  }
  if (empty($siteid))
    $siteid = 1;
  return $siteid;
}

/**
 * 获取用户昵称
 * 不传入userid取当前用户nickname,如果nickname为空取username
 * 传入field，取用户$field字段信息
 */
function get_nickname($userid = '', $field = '') {
  $return = '';
  if (is_numeric($userid)) {
    $member_db = pc_base::load_model('member_model');
    $memberinfo = $member_db->get_one(array(
      'userid' => $userid
    ));
    if (!empty($field) && $field != 'nickname' && isset($memberinfo[$field]) && !empty($memberinfo[$field])) {
      $return = $memberinfo[$field];
    } else {
      $return = isset($memberinfo['nickname']) && !empty($memberinfo['nickname']) ? $memberinfo['nickname'] . '(' . $memberinfo['username'] . ')' : $memberinfo['username'];
    }
  } else {
    if (param::get_cookie('_nickname')) {
      $return .= '(' . param::get_cookie('_nickname') . ')';
    } else {
      $return .= '(' . param::get_cookie('_username') . ')';
    }
  }
  return $return;
}

/**
 * 获取用户信息
 * 不传入$field返回用户所有信息,
 * 传入field，取用户$field字段信息
 */
function get_memberinfo($userid, $field = '') {
  if (!is_numeric($userid)) {
    return false;
  } else {
    static $memberinfo;
    if (!isset($memberinfo[$userid])) {
      $member_db = pc_base::load_model('member_model');
      $memberinfo[$userid] = $member_db->get_one(array(
        'userid' => $userid
      ));
    }
    if (!empty($field) && !empty($memberinfo[$userid][$field])) {
      return $memberinfo[$userid][$field];
    } else {
      return $memberinfo[$userid];
    }
  }
}

/**
 * 通过 username 值，获取用户所有信息
 * 获取用户信息
 * 不传入$field返回用户所有信息,
 * 传入field，取用户$field字段信息
 */
function get_memberinfo_buyusername($username, $field = '') {
  if (empty($username)) {
    return false;
  }
  static $memberinfo;
  if (!isset($memberinfo[$username])) {
    $member_db = pc_base::load_model('member_model');
    $memberinfo[$username] = $member_db->get_one(array(
      'username' => $username
    ));
  }
  if (!empty($field) && !empty($memberinfo[$username][$field])) {
    return $memberinfo[$username][$field];
  } else {
    return $memberinfo[$username];
  }
}

/**
 * 获取用户头像，建议传入phpssouid
 *
 * @param $uid 默认为phpssouid
 * @param $is_userid $uid是否为v9
 *            userid，如果为真，执行sql查询此用户的phpssouid
 * @param $size 头像大小
 *            有四种[30x30 45x45 90x90 180x180] 默认30
 */
function get_memberavatar($uid, $is_userid = '', $size = '30') {
  if ($is_userid) {
    $db = pc_base::load_model('member_model');
    $memberinfo = $db->get_one(array(
      'userid' => $uid
    ));
    if (isset($memberinfo['phpssouid'])) {
      $uid = $memberinfo['phpssouid'];
    } else {
      return false;
    }
  }

  pc_base::load_app_class('client', 'member', 0);
  define('APPID', pc_base::load_config('system', 'phpsso_appid'));
  $phpsso_api_url = pc_base::load_config('system', 'phpsso_api_url');
  $phpsso_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
  $client = new client($phpsso_api_url, $phpsso_auth_key);
  $avatar = $client->ps_getavatar($uid);
  if (isset($avatar[$size])) {
    return $avatar[$size];
  } else {
    return false;
  }
}

/**
 * 调用关联菜单
 *
 * @param $linkageid 联动菜单id
 * @param $id 生成联动菜单的样式id
 * @param $defaultvalue 默认值
 */
function menu_linkage($linkageid = 0, $id = 'linkid', $defaultvalue = 0) {
  $linkageid = intval($linkageid);
  $datas = array();
  $datas = getcache($linkageid, 'linkage');
  $infos = $datas['data'];

  if ($datas['style'] == '1') {
    $title = $datas['title'];
    $container = 'content' . random(3) . date('is');
    if (!defined('DIALOG_INIT_1')) {
      define('DIALOG_INIT_1', 1);
      $string .= '<script type="text/javascript" src="' . JS_PATH . 'dialog.js"></script>';
      // TODO $string .= '<link href="'.CSS_PATH.'dialog.css" rel="stylesheet"
      // type="text/css">';
    }
    if (!defined('LINKAGE_INIT_1')) {
      define('LINKAGE_INIT_1', 1);
      $string .= '<script type="text/javascript" src="' . JS_PATH . 'linkage/js/pop.js"></script>';
    }
    $var_div = $defaultvalue && (ROUTE_A == 'edit' || ROUTE_A == 'account_manage_info' || ROUTE_A == 'info_publish' || ROUTE_A == 'orderinfo') ? menu_linkage_level($defaultvalue, $linkageid, $infos) : $datas['title'];
    $var_input = $defaultvalue && (ROUTE_A == 'edit' || ROUTE_A == 'account_manage_info' || ROUTE_A == 'info_publish') ? '<input type="hidden" name="info[' . $id . ']" value="' . $defaultvalue . '">' : '<input type="hidden" name="info[' . $id . ']" value="">';
    $string .= '<div name="' . $id . '" value="" id="' . $id . '" class="ib">' . $var_div . '</div>' . $var_input . ' <input type="button" name="btn_' . $id . '" class="button" value="' . L('linkage_select') . '" onclick="open_linkage(\'' . $id . '\',\'' . $title . '\',' . $container . ',\'' . $linkageid . '\')">';
    $string .= '<script type="text/javascript">';
    $string .= 'var returnid_' . $id . '= \'' . $id . '\';';
    $string .= 'var returnkeyid_' . $id . ' = \'' . $linkageid . '\';';
    $string .= 'var ' . $container . ' = new Array(';
    foreach ($infos as $k => $v) {
      if ($v['parentid'] == 0) {
        $s[] = 'new Array(\'' . $v['linkageid'] . '\',\'' . $v['name'] . '\',\'' . $v['parentid'] . '\')';
      } else {
        continue;
      }
    }
    $s = implode(',', $s);
    $string .= $s;
    $string .= ')';
    $string .= '</script>';
  } elseif ($datas['style'] == '2') {
    if (!defined('LINKAGE_INIT_1')) {
      define('LINKAGE_INIT_1', 1);
      $string .= '<script type="text/javascript" src="' . JS_PATH . 'linkage/js/jquery.ld.js"></script>';
    }
    $default_txt = '';
    if ($defaultvalue) {
      $default_txt = menu_linkage_level($defaultvalue, $linkageid, $infos);
      $default_txt = '["' . str_replace(' > ', '","', $default_txt) . '"]';
    }
    $string .= $defaultvalue && (ROUTE_A == 'edit' || ROUTE_A == 'account_manage_info' || ROUTE_A == 'info_publish') ? '<input type="hidden" name="info[' . $id . ']"  id="' . $id . '" value="' . $defaultvalue . '">' : '<input type="hidden" name="info[' . $id . ']"  id="' . $id . '" value="">';

    for ($i = 1; $i <= $datas['setting']['level']; $i ++) {
      $string .= '<select class="pc-select-' . $id . '" name="' . $id . '-' . $i . '" id="' . $id . '-' . $i . '" width="100"><option value="">请选择菜单</option></select> ';
    }

    $string .= '<script type="text/javascript">
					$(function(){
						var $ld5 = $(".pc-select-' . $id . '");
						$ld5.ld({ajaxOptions : {"url" : "' . APP_PATH . 'api.php?op=get_linkage&act=ajax_select&keyid=' . $linkageid . '"},defaultParentId : 0,style : {"width" : 120}})
						var ld5_api = $ld5.ld("api");
						ld5_api.selected(' . $default_txt . ');
						$ld5.bind("change",onchange);
						function onchange(e){
							var $target = $(e.target);
							var index = $ld5.index($target);
							$("#' . $id . '-' . $i . '").remove();
							$("#' . $id . '").val($ld5.eq(index).show().val());
							index ++;
							$ld5.eq(index).show();								}
					})
		</script>';
  } else {
    $title = $defaultvalue ? $infos[$defaultvalue]['name'] : $datas['title'];
    $colObj = random(3) . date('is');
    $string = '';
    if (!defined('LINKAGE_INIT')) {
      define('LINKAGE_INIT', 1);
      $string .= '<script type="text/javascript" src="' . JS_PATH . 'linkage/js/mln.colselect.js"></script>';
      if (defined('IN_ADMIN')) {
        $string .= '<link href="' . JS_PATH . 'linkage/style/admin.css" rel="stylesheet" type="text/css">';
      } else {
        $string .= '<link href="' . JS_PATH . 'linkage/style/css.css" rel="stylesheet" type="text/css">';
      }
    }
    $string .= '<input type="hidden" name="info[' . $id . ']" value="1"><div id="' . $id . '"></div>';
    $string .= '<script type="text/javascript">';
    $string .= 'var colObj' . $colObj . ' = {"Items":[';

    foreach ($infos as $k => $v) {
      $s .= '{"name":"' . $v['name'] . '","topid":"' . $v['parentid'] . '","colid":"' . $k . '","value":"' . $k . '","fun":function(){}},';
    }

    $string .= substr($s, 0, - 1);
    $string .= ']};';
    $string .= '$("#' . $id . '").mlnColsel(colObj' . $colObj . ',{';
    $string .= 'title:"' . $title . '",';
    $string .= 'value:"' . $defaultvalue . '",';
    $string .= 'width:100';
    $string .= '});';
    $string .= '</script>';
  }
  return $string;
}

/**
 * 联动菜单层级
 */
function menu_linkage_level($linkageid, $keyid, $infos, $result = array()) {
  if (array_key_exists($linkageid, $infos)) {
    $result[] = $infos[$linkageid]['name'];
    return menu_linkage_level($infos[$linkageid]['parentid'], $keyid, $infos, $result);
  }
  krsort($result);
  return implode(' > ', $result);
}

/**
 * 通过catid获取显示菜单完整结构
 *
 * @param $menuid 菜单ID
 * @param $cache_file 菜单缓存文件名称
 * @param $cache_path 缓存文件目录
 * @param $key 取得缓存值的键值名称
 * @param $parentkey 父级的ID
 * @param $linkstring 链接字符
 */
function menu_level($menuid, $cache_file, $cache_path = 'commons', $key = 'catname', $parentkey = 'parentid', $linkstring = ' > ', $result = array()) {
  $menu_arr = getcache($cache_file, $cache_path);
  if (array_key_exists($menuid, $menu_arr)) {
    $result[] = $menu_arr[$menuid][$key];
    return menu_level($menu_arr[$menuid][$parentkey], $cache_file, $cache_path, $key, $parentkey, $linkstring, $result);
  }
  krsort($result);
  return implode($linkstring, $result);
}

/**
 * 通过id获取显示联动菜单
 *
 * @param $linkageid 联动菜单ID
 * @param $keyid 菜单keyid
 * @param $space 菜单间隔符
 * @param $tyoe 1
 *            返回间隔符链接，完整路径名称 3 返回完整路径数组，2返回当前联动菜单名称，4 直接返回ID
 * @param $result 递归使用字段1
 * @param $infos 递归使用字段2
 */
function get_linkage($linkageid, $keyid, $space = '>', $type = 1, $result = array(), $infos = array()) {
  if ($space == '' || !isset($space))
    $space = '>';
  if (!$infos) {
    $datas = getcache($keyid, 'linkage');
    $infos = $datas['data'];
  }
  if ($type == 1 || $type == 3 || $type == 4) {
    if (array_key_exists($linkageid, $infos)) {
      $result[] = ($type == 1) ? $infos[$linkageid]['name'] : (($type == 4) ? $linkageid : $infos[$linkageid]);
      return get_linkage($infos[$linkageid]['parentid'], $keyid, $space, $type, $result, $infos);
    } else {
      if (count($result) > 0) {
        krsort($result);
        if ($type == 1 || $type == 4)
          $result = implode($space, $result);
        return $result;
      } else {
        return $result;
      }
    }
  } else {
    return $infos[$linkageid]['name'];
  }
}

/**
 * IE浏览器判断
 */
function is_ie() {
  $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
  if ((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false))
    return false;
  if (strpos($useragent, 'msie ') !== false)
    return true;
  return false;
}

/**
 * 文件下载
 *
 * @param $filepath 文件路径
 * @param $filename 文件名称
 */
function file_down($filepath, $filename = '') {
  if (!$filename)
    $filename = basename($filepath);
  if (is_ie())
    $filename = rawurlencode($filename);
  $filetype = fileext($filename);
  $filesize = sprintf("%u", filesize($filepath));
  if (ob_get_length() !== false)
    @ob_end_clean();
  header('Pragma: public');
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: pre-check=0, post-check=0, max-age=0');
  header('Content-Transfer-Encoding: binary');
  header('Content-Encoding: none');
  header('Content-type: ' . $filetype);
  header('Content-Disposition: attachment; filename="' . $filename . '"');
  header('Content-length: ' . $filesize);
  readfile($filepath);
  exit();
}

/**
 * 判断字符串是否为utf8编码，英文和半角字符返回ture
 *
 * @param
 *            $string
 * @return bool
 */
function is_utf8($string) {
  return preg_match('%^(?:
					[\x09\x0A\x0D\x20-\x7E] # ASCII
					| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
					| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
					| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
					| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
					| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
					| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
					| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
					)*$%xs', $string);
}

/**
 * 组装生成ID号
 *
 * @param $modules 模块名
 * @param $contentid 内容ID
 * @param $siteid 站点ID
 */
function id_encode($modules, $contentid, $siteid) {
  return urlencode($modules . '-' . $contentid . '-' . $siteid);
}

/**
 * 解析ID
 *
 * @param $id 评论ID
 */
function id_decode($id) {
  return explode('-', $id);
}

/**
 * 对用户的密码进行加密
 *
 * @param
 *            $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt = '') {
  $pwd = array();
  $pwd['encrypt'] = $encrypt ? $encrypt : create_randomstr();
  $pwd['password'] = md5(md5(trim($password)) . $pwd['encrypt']);
  return $encrypt ? $pwd['password'] : $pwd;
}

/**
 * 生成随机字符串
 *
 * @param string $lenth
 *            长度
 * @return string 字符串
 */
function create_randomstr($len = 6) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    mt_srand(10000000*(double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
    $str .= $chars[mt_rand(0, $lc)];
    }
    return $str;
}

/**
 * 检查密码长度是否符合规定
 *
 * @param STRING $password
 * @return TRUE or FALSE
 */
function is_password($password) {
  $strlen = strlen($password);
  if ($strlen >= 6 && $strlen <= 20)
    return true;
  return false;
}

/**
 * 检测输入中是否含有错误字符
 *
 * @param char $string
 *            要检查的字符串名称
 * @return TRUE or FALSE
 */
function is_badword($string) {
  $badwords = array(
    "\\",
    '&',
    ' ',
    "'",
    '"',
    '/',
    '*',
    ',',
    '<',
    '>',
    "\r",
    "\t",
    "\n",
    "#"
  );
  foreach ($badwords as $value) {
    if (strpos($string, $value) !== FALSE) {
      return TRUE;
    }
  }
  return FALSE;
}

/**
 * 检查用户名是否符合规定
 *
 * @param STRING $username
 *            要检查的用户名
 * @return TRUE or FALSE
 */
function is_username($username) {
  $strlen = strlen($username);
  if (is_badword($username) || !preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $username)) {
    return false;
  } elseif (20 < $strlen || $strlen < 2) {
    return false;
  }
  return true;
}

/**
 * 检查id是否存在于数组中
 *
 * @param
 *            $id
 * @param
 *            $ids
 * @param
 *            $s
 */
function check_in($id, $ids = '', $s = ',') {
  if (!$ids)
    return false;
  $ids = explode($s, $ids);
  return is_array($id) ? array_intersect($id, $ids) : in_array($id, $ids);
}

/**
 * 对数据进行编码转换
 *
 * @param array/string $data
 *            数组
 * @param string $input
 *            需要转换的编码
 * @param string $output
 *            转换后的编码
 */
function array_iconv($data, $input = 'gbk', $output = 'utf-8') {
  if (!is_array($data)) {
    return iconv($input, $output, $data);
  } else {
    foreach ($data as $key => $val) {
      if (is_array($val)) {
        $data[$key] = array_iconv($val, $input, $output);
      } else {
        $data[$key] = iconv($input, $output, $val);
      }
    }
    return $data;
  }
}

/**
 * 生成缩略图函数
 *
 * @param $imgurl 图片路径
 * @param $width 缩略图宽度
 * @param $height 缩略图高度
 * @param $autocut 是否自动裁剪
 *            默认裁剪，当高度或宽度有一个数值为0是，自动关闭
 * @param $smallpic 无图片是默认图片路径
 */
function thumb($imgurl, $width = 100, $height = 100, $autocut = 1, $smallpic = 'nopic.gif') {
  global $image;
  $upload_url = pc_base::load_config('system', 'upload_url');
  $upload_path = pc_base::load_config('system', 'upload_path');
  if (empty($imgurl))
    return IMG_PATH . $smallpic;
  $imgurl_replace = str_replace($upload_url, '', $imgurl);
  if (!extension_loaded('gd') || strpos($imgurl_replace, '://'))
    return $imgurl;
  if (!file_exists($imgurl_replace))
    return IMG_PATH . $smallpic;

  list ($width_t, $height_t, $type, $attr) = getimagesize($imgurl_replace);
  if ($width >= $width_t || $height >= $height_t)
    return $imgurl;
  $newimgurl = dirname($imgurl_replace) . '/thumb_' . $width . '_' . $height . '_' . basename($imgurl_replace);
  if (file_exists($upload_path . $newimgurl))
    return $newimgurl;

  if (!is_object($image)) {
    pc_base::load_sys_class('image', '', '0');
    $image = new image(1, 0);
  }
  return $image->thumb($imgurl_replace, $newimgurl, $width, $height, '', $autocut) ? $upload_url . $newimgurl : $imgurl;
}

/**
 * 水印添加
 *
 * @param $source 原图片路径
 * @param $target 生成水印图片途径，默认为空，覆盖原图
 * @param $siteid 站点id，系统需根据站点id获取水印信息
 */
function watermark($source, $target = '', $siteid) {
  global $image_w;
  if (empty($source))
    return $source;
  if (!extension_loaded('gd') || strpos($source, '://'))
    return $source;
  if (!$target)
    $target = $source;
  if (!is_object($image_w)) {
    pc_base::load_sys_class('image', '', '0');
    $image_w = new image(0, $siteid);
  }
  $image_w->watermark($source, $target);
  return $target;
}

/**
 * 当前路径
 * 返回指定栏目路径层级
 *
 * @param $catid 栏目id
 * @param $symbol 栏目间隔符
 */
function catpos($catid, $symbol = ' > ') {
  $category_arr = array();
  $siteids = getcache('category_content', 'commons');
  $siteid = $siteids[$catid];
  $category_arr = getcache('category_content_' . $siteid, 'commons');
  if (!isset($category_arr[$catid]))
    return '';
  $pos = '';
  $siteurl = siteurl($category_arr[$catid]['siteid']);
  $arrparentid = array_filter(explode(',', $category_arr[$catid]['arrparentid'] . ',' . $catid));
  foreach ($arrparentid as $catid) {
    $url = $category_arr[$catid]['url'];
    if (strpos($url, '://') === false)
      $url = $siteurl . $url;
    $pos .= '<a href="' . $url . '">' . $category_arr[$catid]['catname'] . '</a>' . $symbol;
  }
  return $pos;
}

/**
 * 根据catid获取子栏目数据的sql语句
 *
 * @param string $module
 *            缓存文件名
 * @param intval $catid
 *            栏目ID
 */
function get_sql_catid($file = 'category_content_1', $catid = 0, $module = 'commons') {
  $category = getcache($file, $module);
  $catid = intval($catid);
  if (!isset($category[$catid]))
    return false;
  return $category[$catid]['child'] ? " `catid` IN(" . $category[$catid]['arrchildid'] . ") " : " `catid`=$catid ";
}

/**
 * 获取子栏目
 *
 * @param $parentid 父级id
 * @param $type 栏目类型
 * @param $self 是否包含本身
 *            0为不包含
 * @param $siteid 站点id
 */
function subcat($parentid = NULL, $type = NULL, $self = '0', $siteid = '') {
  if (empty($siteid))
    $siteid = get_siteid();
  $category = getcache('category_content_' . $siteid, 'commons');
  foreach ($category as $id => $cat) {
    if ($cat['siteid'] == $siteid && ($parentid === NULL || $cat['parentid'] == $parentid) && ($type === NULL || $cat['type'] == $type))
      $subcat[$id] = $cat;
    if ($self == 1 && $cat['catid'] == $parentid && !$cat['child'])
      $subcat[$id] = $cat;
  }
  return $subcat;
}

/**
 * 获取内容地址
 *
 * @param $catid 栏目ID
 * @param $id 文章ID
 * @param $allurl 是否以绝对路径返回
 */
function go($catid, $id, $allurl = 0) {
  static $category;
  if (empty($category)) {
    $siteids = getcache('category_content', 'commons');
    $siteid = $siteids[$catid];
    $category = getcache('category_content_' . $siteid, 'commons');
  }
  $id = intval($id);
  if (!$id || !isset($category[$catid]))
    return '';
  $modelid = $category[$catid]['modelid'];
  if (!$modelid)
    return '';
  $db = pc_base::load_model('content_model');
  $db->set_model($modelid);
  $r = $db->get_one(array(
    'id' => $id
    ), '`url`');
  if (!empty($allurl)) {
    if (strpos($r['url'], '://') === false) {
      if (strpos($category[$catid]['url'], '://') === FALSE) {
        $site = siteinfo($category[$catid]['siteid']);
        $r['url'] = substr($site['domain'], 0, - 1) . $r['url'];
      } else {
        $r['url'] = $category[$catid]['url'] . $r['url'];
      }
    }
  }

  return $r['url'];
}

/**
 * 将附件地址转换为绝对地址
 *
 * @param $path 附件地址
 */
function atturl($path) {
  if (strpos($path, ':/')) {
    return $path;
  } else {
    $sitelist = getcache('sitelist', 'commons');
    $siteid = get_siteid();
    $siteurl = $sitelist[$siteid]['domain'];
    $domainlen = strlen($sitelist[$siteid]['domain']) - 1;
    $path = $siteurl . $path;
    $path = substr_replace($path, '/', strpos($path, '//', $domainlen), 2);
    return $path;
  }
}

/**
 * 判断模块是否安装
 *
 * @param $m 模块名称
 */
function module_exists($m = '') {
  if ($m == 'admin')
    return true;
  $modules = getcache('modules', 'commons');
  $modules = array_keys($modules);
  return in_array($m, $modules);
}

/**
 * 生成SEO
 *
 * @param $siteid 站点ID
 * @param $catid 栏目ID
 * @param $title 标题
 * @param $description 描述
 * @param $keyword 关键词
 */
function seo($siteid, $catid = '', $title = '', $description = '', $keyword = '') {
  if (!empty($title))
    $title = strip_tags($title);
  if (!empty($description))
    $description = strip_tags($description);
  if (!empty($keyword))
    $keyword = str_replace(' ', ',', strip_tags($keyword));
  $sites = getcache('sitelist', 'commons');
  $site = $sites[$siteid];
  $cat = array();
  if (!empty($catid)) {
    $siteids = getcache('category_content', 'commons');
    $siteid = $siteids[$catid];
    $categorys = getcache('category_content_' . $siteid, 'commons');
    $cat = $categorys[$catid];
    $cat['setting'] = string2array($cat['setting']);
  }
  $seo['site_title'] = isset($site['site_title']) && !empty($site['site_title']) ? $site['site_title'] : $site['name'];
  $seo['keyword'] = !empty($keyword) ? $keyword : $site['keywords'];
  $seo['description'] = isset($description) && !empty($description) ? $description : (isset($cat['setting']['meta_description']) && !empty($cat['setting']['meta_description']) ? $cat['setting']['meta_description'] : (isset($site['description']) && !empty($site['description']) ? $site['description'] : ''));
  $seo['title'] = (isset($title) && !empty($title) ? $title . ' - ' : '') . (isset($cat['setting']['meta_title']) && !empty($cat['setting']['meta_title']) ? $cat['setting']['meta_title'] . ' - ' : (isset($cat['catname']) && !empty($cat['catname']) ? $cat['catname'] . ' - ' : ''));
  foreach ($seo as $k => $v) {
    $seo[$k] = str_replace(array(
      "\n",
      "\r"
      ), '', $v);
  }
  return $seo;
}

/**
 * 获取站点的信息
 *
 * @param $siteid 站点ID
 */
function siteinfo($siteid) {
  static $sitelist;
  if (empty($sitelist))
    $sitelist = getcache('sitelist', 'commons');
  return isset($sitelist[$siteid]) ? $sitelist[$siteid] : '';
}

/**
 * 生成CNZZ统计代码
 */
function tjcode() {
  if (!module_exists('cnzz'))
    return false;
  $config = getcache('cnzz', 'commons');
  if (empty($config)) {
    return false;
  } else {
    return '<script src=\'http://pw.cnzz.com/c.php?id=' . $config['siteid'] . '&l=2\' language=\'JavaScript\' charset=\'gb2312\'></script>';
  }
}

/**
 * 生成标题样式
 *
 * @param $style 样式
 * @param $html 是否显示完整的STYLE
 */
function title_style($style, $html = 1) {
  $str = '';
  if ($html)
    $str = ' style="';
  $style_arr = explode(';', $style);
  if (!empty($style_arr[0]))
    $str .= 'color:' . $style_arr[0] . ';';
  if (!empty($style_arr[1]))
    $str .= 'font-weight:' . $style_arr[1] . ';';
  if ($html)
    $str .= '" ';
  return $str;
}

/**
 * 获取站点域名
 *
 * @param $siteid 站点id
 */
function siteurl($siteid) {
  static $sitelist;
  if (!$siteid)
    return WEB_PATH;
  if (empty($sitelist))
    $sitelist = getcache('sitelist', 'commons');
  return substr($sitelist[$siteid]['domain'], 0, - 1);
}

/**
 * 生成上传附件验证
 *
 * @param $args 参数
 * @param $operation 操作类型(加密解密)
 */
function upload_key($args) {
  $pc_auth_key = md5(pc_base::load_config('system', 'auth_key') . $_SERVER['HTTP_USER_AGENT']);
  $authkey = md5($args . $pc_auth_key);
  return $authkey;
}

/**
 * 文本转换为图片
 *
 * @param string $txt
 *            图形化文本内容
 * @param int $fonttype
 *            无外部字体时生成文字大小，取值范围1-5
 * @param int $fontsize
 *            引入外部字体时，字体大小
 * @param string $font
 *            字体名称 字体请放于dnw\libs\data\font下
 * @param string $fontcolor
 *            字体颜色 十六进制形式 如FFFFFF,FF0000
 */
function string2img($txt, $fonttype = 5, $fontsize = 16, $font = '', $fontcolor = 'FF0000', $transparent = '1') {
  if (empty($txt))
    return false;
  if (function_exists("imagepng")) {
    $txt = urlencode(sys_auth($txt));
    $txt = '<img src="' . APP_PATH . 'api.php?op=creatimg&txt=' . $txt . '&fonttype=' . $fonttype . '&fontsize=' . $fontsize . '&font=' . $font . '&fontcolor=' . $fontcolor . '&transparent=' . $transparent . '" align="absmiddle">';
  }
  return $txt;
}

/**
 * 获取dnw版本号
 */
function get_pc_version($type = '') {
  $version = pc_base::load_config('version');
  if ($type == 1) {
    return $version['pc_version'];
  } elseif ($type == 2) {
    return $version['pc_release'];
  } else {
    return $version['pc_version'] . ' ' . $version['pc_release'];
  }
}

/**
 * 运行钩子（插件使用）
 */
function runhook($method) {
  $time_start = getmicrotime();
  $data = '';
  $getpclass = FALSE;
  $hook_appid = getcache('hook', 'plugins');
  if (!empty($hook_appid)) {
    foreach ($hook_appid as $appid => $p) {
      $pluginfilepath = PC_PATH . 'plugin' . DIRECTORY_SEPARATOR . $p . DIRECTORY_SEPARATOR . 'hook.class.php';
      $getpclass = TRUE;
      include_once $pluginfilepath;
    }
    $hook_appid = array_flip($hook_appid);
    if ($getpclass) {
      $pclass = new ReflectionClass('hook');
      foreach ($pclass->getMethods() as $r) {
        $legalmethods[] = $r->getName();
      }
    }
    if (in_array($method, $legalmethods)) {
      foreach (get_declared_classes() as $class) {
        $refclass = new ReflectionClass($class);
        if ($refclass->isSubclassOf('hook')) {
          if ($_method = $refclass->getMethod($method)) {
            $classname = $refclass->getName();
            if ($_method->isPublic() && $_method->isFinal()) {
              plugin_stat($hook_appid[$classname]);
              $data .= $_method->invoke(null);
            }
          }
        }
      }
    }
    return $data;
  }
}

function getmicrotime() {
  list ($usec, $sec) = explode(" ", microtime());
  return ((float) $usec + (float) $sec);
}

/**
 * 插件前台模板加载
 * Enter description here .
 *
 *
 *
 *
 *
 * ..
 *
 * @param unknown_type $module
 * @param unknown_type $template
 * @param unknown_type $style
 */
function p_template($plugin = 'content', $template = 'index', $style = 'default') {
  if (!$style)
    $style = 'default';
  $template_cache = pc_base::load_sys_class('template_cache');
  $compiledtplfile = PHPFRAME_PATH . 'caches' . DIRECTORY_SEPARATOR . 'caches_template' . DIRECTORY_SEPARATOR . $style . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . $template . '.php';

  if (!file_exists($compiledtplfile) || (file_exists(PC_PATH . 'plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . '.html') && filemtime(PC_PATH . 'plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . '.html') > filemtime($compiledtplfile))) {
    $template_cache->template_compile('plugin/' . $plugin, $template, 'default');
  } elseif (!file_exists(PC_PATH . 'plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . '.html')) {
    showmessage('Template does not exist.' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . $template . '.html');
  }

  return $compiledtplfile;
}

/**
 * 读取缓存动态页面
 */
function cache_page_start() {
  $relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . safe_replace($_SERVER['QUERY_STRING']) : $path_info);
  define('CACHE_PAGE_ID', md5($relate_url));
  $contents = getcache(CACHE_PAGE_ID, 'page_tmp/' . substr(CACHE_PAGE_ID, 0, 2));
  if ($contents && intval(substr($contents, 15, 10)) > SYS_TIME) {
    echo substr($contents, 29);
    exit();
  }
  if (!defined('HTML'))
    define('HTML', true);
  return true;
}

/**
 * 写入缓存动态页面
 */
function cache_page($ttl = 360, $isjs = 0) {
  if ($ttl == 0 || !defined('CACHE_PAGE_ID'))
    return false;
  $contents = ob_get_contents();

  if ($isjs)
    $contents = format_js($contents);
  $contents = "<!--expiretime:" . (SYS_TIME + $ttl) . "-->\n" . $contents;
  setcache(CACHE_PAGE_ID, $contents, 'page_tmp/' . substr(CACHE_PAGE_ID, 0, 2));
}

/**
 *
 *
 *
 * 获取远程内容
 *
 * @param $url 接口url地址
 * @param $timeout 超时时间
 */
function pc_file_get_contents($url, $timeout = 30) {
  $stream = stream_context_create(array(
    'http' => array(
      'timeout' => $timeout
    )
  ));
  return @file_get_contents($url, 0, $stream);
}

/**
 * Function get_vid
 * 获取视频信息
 *
 * @param int $contentid
 *            内容ID 必须
 * @param int $catid
 *            栏目id 取内容里面视频信息时必须
 * @param int $isspecial
 *            是否取专题的视频信息
 */
function get_vid($contentid = 0, $catid = 0, $isspecial = 0) {
  static $categorys;
  if (!$contentid)
    return false;
  if (!$isspecial) {
    if (!$catid)
      return false;
    $contentid = intval($contentid);
    $catid = intval($catid);
    $siteid = get_siteid();
    if (!$categorys) {
      $categorys = getcache('category_content_' . $siteid, 'commons');
    }
    $modelid = $categorys[$catid]['modelid'];
    $video_content = pc_base::load_model('video_content_model');
    $r = $video_content->get_one(array(
      'contentid' => $contentid,
      'modelid' => $modelid
      ), 'videoid', '`listorder` ASC');
    $video_store = pc_base::load_model('video_store_model');
    return $video_store->get_one(array(
        'videoid' => $r['videoid']
    ));
  } else {
    $special_content = pc_base::load_model('special_content_model');
    $contentid = intval($contentid);
    $video_store = pc_base::load_model('video_store_model');
    $r = $special_content->get_one(array(
      'id' => $contentid
      ), 'videoid');
    return $video_store->get_one(array(
        'videoid' => $r['videoid']
    ));
  }
}

/**
 * Function dataformat
 * 时间转换
 *
 * @param $n INT时间
 */
function dataformat($n) {
  $hours = floor($n / 3600);
  $minite = floor($n % 3600 / 60);
  $secend = floor($n % 3600 % 60);
  $minite = $minite < 10 ? "0" . $minite : $minite;
  $secend = $secend < 10 ? "0" . $secend : $secend;
  if ($n >= 3600) {
    return $hours . ":" . $minite . ":" . $secend;
  } else {
    return $minite . ":" . $secend;
  }
}

/**
 * 格式化数据并输出Jsonp数据
 *
 * @param		int 	$result  表示结果码 0 - 表示请求成功  非0 - 表示出现错误或异常
 * @param		string  $message 提示信息
 * @param		array   $data	 数据列表
 * @return		array	格式化后的数据
 */
function returnJsonp($result, $message = '', $data = '', $page = '') {
  if (!empty($page)) {
    $json = array('result' => $result, 'message' => $message, 'data' => $data, 'page' => $page);
  } else {
    $json = array('result' => $result, 'message' => $message, 'data' => $data);
  }
  $callback = getgpc('callback');
  $callback = isset($callback) ? $callback : 'callback';
  echo $callback . '(' . json_encode($json) . ')';
  exit();
}

function returnOss($errorCode, $description = '', $data = '', $name = '', $page = '') {
  if (!empty($page)) {
    $json = array('errorCode' => $errorCode, 'description' => $description, 'data' => $data, 'name' => $name, 'page' => $page);
  } else {
    $json = array('errorCode' => $errorCode, 'description' => $description, 'data' => $data, 'name' => $name);
  }
  $arr = json_encode($json);

  file_put_contents('./json/' . $name . '.json', $arr);
  $user_path = "./json/" . $name . ".json";
  if (!file_exists($user_path)) {
    echo 'file exists error';
    die;
  }
  require_once '../phpframe/plugin/aloss/samples/Common.php';
  $ossClient = Common::getOssClient();
  $dir = 'mxyy/rest';
  $file_name = $dir . '/' . $name . '.json';
  // echo 111;
  $response = $ossClient->createObjectDir('mxyy', $dir);
  $response = $ossClient->uploadFile('mxyy', $file_name, $user_path);
  // var_dump($response);
  unlink($user_path);
}

function returnJson($errorCode, $description = '', $data = '', $page = '') {
  if (!empty($page)) {
    $json = array('errorCode' => $errorCode, 'description' => $description, 'data' => $data, 'page' => $page);
  } else {
    $json = array('errorCode' => $errorCode, 'description' => $description, 'data' => $data);
  }
  echo json_encode($json);
  exit();
}

//xls上传导入
function uploadXLS($file, $filetempname) {
  //自己设置的上传文件存放路径
  $filePath = '../phpframe/runtime/';
  $str = "";
  //下面的路径按照你PHPExcel的路径来修改
  require_once '../phpframe/libs/classes/PHPExcel.php';
  require_once '../phpframe/libs/classes/PHPExcel/IOFactory.php';
  require_once '../phpframe/libs/classes/PHPExcel/Reader/Excel5.php';

  //注意设置时区
  $time = date("y_m_d_H_i_s"); //去当前上传的时间
  //获取上传文件的扩展名
  //$extend=strrchr ($file,'.');
  //上传后的文件名
  //$name=$file.$extend;
  $name = $file;
  $uploadfile = $filePath . $name; //上传后的文件名地址
  //move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
  $result = move_uploaded_file($filetempname, $uploadfile); //假如上传到当前目录下
  if ($result) { //如果上传文件成功，就执行导入excel操作
    $objReader = PHPExcel_IOFactory::createReader('Excel5'); //use excel2007 for 2007 format
    $objPHPExcel = $objReader->load($uploadfile);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();           //取得总行数
    $highestColumn = $sheet->getHighestColumn(); //取得总列数

    /* 第二种方法 */
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow();
    //echo 'highestRow='.$highestRow;
    //echo "<br>";
    $highestColumn = $objWorksheet->getHighestColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); //总列数
    //echo 'highestColumnIndex='.$highestColumnIndex;
    //echo "<br>";
    $headtitle = array();
    $bodyArr = array();
    for ($row = 1; $row <= $highestRow; $row++) {
      $strs = array();
      //注意highestColumnIndex的列数索引从0开始
      for ($col = 0; $col < $highestColumnIndex; $col++) {
        $strs[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
      }
      $bodyArr[] = $strs;
    }
    return $bodyArr;
  } else {
    $msg = false;
  }
  return $msg;
}

function curlRequest($url, $params = array(), $headers = array()) {
  if (empty($url)) {
    return false;
  }

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
  $returnStr = curl_exec($ch);
  curl_close($ch);

  return $returnStr;
}

function wx_curl($url, $params = array(), $headers = array()) {
  if (empty($url)) {
    return false;
  }

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $ret = curl_exec($ch);
  curl_close($ch);

  return $ret;
}

function round_x($num) {
  if ($num == 0) {
    $num = 0;
  } elseif ($num < 0.0001) {
    $num = $num;
  } else {
    $num = round($num, 8);
  }
  return $num;
}

function get_microtime() {
  list($msec, $sec) = explode(' ', microtime());
  $msectime = (float) sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
  return $msectimes = substr($msectime, 0, 13);
}

//************   中文字符串 首字母 转英文大写    *****************************************************
function get_letter($string) {
  //生成字符串数组
  $charlist = mb_str_split($string);
  //接收多个字符串，返回每个字符首字母大写

  return implode(array_map("get_a_z", $charlist));
}

function mb_str_split($string) {
  // 正则，字符串分割成数组
  return preg_split('/(?<!^)(?!$)/u', $string);
}

function get_a_z($s0) {
  //获取传入字符串数组第一个字符
  $fchar = ord(substr($s0, 0, 1));
  //如果字符值>=a,<=z的编码，说明本身就是字母，chr()转译回字符，strtoupper切换成大写，返回
  if (($fchar >= ord("a") and $fchar <= ord("z"))or ( $fchar >= ord("A") and $fchar <= ord("Z")))
    return strtoupper(chr($fchar));
  //如果上面不成立，说明是汉字进入下面
  //utf8转为gbk
  $s = iconv("UTF-8", "GBK//IGNORE", $s0);
  //gbk第一个字符ascii码 * 256 + gbk第二个字符ascii码 - 65536，取值
  $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
  if ($asc >= -20319 and $asc <= -20284)
    return "A";
  if ($asc >= -20283 and $asc <= -19776)
    return "B";
  if ($asc >= -19775 and $asc <= -19219)
    return "C";
  if ($asc >= -19218 and $asc <= -18711)
    return "D";
  if ($asc >= -18710 and $asc <= -18527)
    return "E";
  if ($asc >= -18526 and $asc <= -18240)
    return "F";
  if ($asc >= -18239 and $asc <= -17923)
    return "G";
  if ($asc >= -17922 and $asc <= -17418)
    return "H";
  if ($asc >= -17417 and $asc <= -16475)
    return "J";
  if ($asc >= -16474 and $asc <= -16213)
    return "K";
  if ($asc >= -16212 and $asc <= -15641)
    return "L";
  if ($asc >= -15640 and $asc <= -15166)
    return "M";
  if ($asc >= -15165 and $asc <= -14923)
    return "N";
  if ($asc >= -14922 and $asc <= -14915)
    return "O";
  if ($asc >= -14914 and $asc <= -14631)
    return "P";
  if ($asc >= -14630 and $asc <= -14150)
    return "Q";
  if ($asc >= -14149 and $asc <= -14091)
    return "R";
  if ($asc >= -14090 and $asc <= -13319)
    return "S";
  if ($asc >= -13318 and $asc <= -12839)
    return "T";
  if ($asc >= -12838 and $asc <= -12557)
    return "W";
  if ($asc >= -12556 and $asc <= -11848)
    return "X";
  if ($asc >= -11847 and $asc <= -11056)
    return "Y";
  if ($asc >= -11055 and $asc <= -10247)
    return "Z";
  return null;
}

function redisSet($key,$arr){
//  $redis = new Redis();
//  $redis->connect('127.0.0.1',6379);
//  $res = $redis->set($key,json_encode($arr));
//  return $res;
}

function redisGet($key){
  $redis = new Redis();
  $redis->connect('127.0.0.1',6379);
  $res = $redis->get($key);
  $arr = json_decode($res,true);
  return $arr;
}

function redisDel($key){
  $redis = new Redis();
  $redis->connect('127.0.0.1',6379);
  $res = $redis->delete($key);
  return $res;
}

function numToWord($num)
{
    $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
    $chiUni = array('','十', '百', '千', '万','十', '百', '千', '亿', '十', '百','千','万','十', '百', '千');
    $uniPro = array(4, 8);
    $chiStr = '';


    $num_str = (string)$num;

    $count = strlen($num_str);
    $last_flag = true; //上一个 是否为0
    $zero_flag = true; //是否第一个
    $temp_num = null; //临时数字
    $uni_index = 0;

    $chiStr = '';//拼接结果
    if ($count == 2) {//两位数
        $temp_num = $num_str[0];
        $chiStr = $temp_num == 1 ? $chiUni[1] :                  $chiNum[$temp_num].$chiUni[1];
        $temp_num = $num_str[1];
        $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
    }else if($count > 2){
        $index = 0;
        for ($i=$count-1; $i >= 0 ; $i--) {
            $temp_num = $num_str[$i];
            if ($temp_num == 0) {
                $uni_index = $index%15;
                if ( in_array($uni_index, $uniPro)) {
                    $chiStr = $chiUni[$uni_index]. $chiStr;
                    $last_flag = true;
                }else if (!$zero_flag && !$last_flag ) {
                   $chiStr = $chiNum[$temp_num]. $chiStr;
                   $last_flag = true;
                }
            }else{
                $chiStr = $chiNum[$temp_num].$chiUni[$index%16] .$chiStr;

               $zero_flag = false;
               $last_flag = false;
            }
           $index ++;
         }
    }else{
        $chiStr = $chiNum[$num_str[0]];
    }
    return $chiStr;
}
?>
