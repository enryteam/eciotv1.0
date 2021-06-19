<?php

/**
* 转化 \ 为 /
* 
* @param	string	$path	路径
* @return	string	路径
*/
function dir_path($path)
{
    $path = str_replace('\\', '/', $path);
    if (substr($path, - 1) != '/')
        $path = $path . '/';
    return $path;
}

/**
 * 创建目录
 *
 * @param string $path            
 * @param string $mode            
 * @return string
 *
 */
function dir_create($path, $mode = 0777)
{
    if (is_dir($path))
        return TRUE;
    $ftp_enable = 0;
    $path = dir_path($path);
    $temp = explode('/', $path);
    $cur_dir = '';
    $max = count($temp) - 1;
    for ($i = 0; $i < $max; $i ++) {
        $cur_dir .= $temp[$i] . '/';
        if (@is_dir($cur_dir))
            continue;
        @mkdir($cur_dir, 0777, true);
        @chmod($cur_dir, 0777);
    }
    return is_dir($path);
}

/**
 * 拷贝目录及下面所有文件
 *
 * @param string $fromdir            
 * @param string $todir            
 * @return string
 *
 */
function dir_copy($fromdir, $todir)
{
    $fromdir = dir_path($fromdir);
    $todir = dir_path($todir);
    if (! is_dir($fromdir))
        return FALSE;
    if (! is_dir($todir))
        dir_create($todir);
    $list = glob($fromdir . '*');
    if (! empty($list)) {
        foreach ($list as $v) {
            $path = $todir . basename($v);
            if (is_dir($v)) {
                dir_copy($v, $path);
            } else {
                copy($v, $path);
                @chmod($path, 0777);
            }
        }
    }
    return TRUE;
}

/**
 * 转换目录下面的所有文件编码格式
 *
 * @param string $in_charset            
 * @param string $out_charset            
 * @param string $dir            
 * @param string $fileexts            
 * @return string
 *
 */
function dir_iconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml')
{
    if ($in_charset == $out_charset)
        return false;
    $list = dir_list($dir);
    foreach ($list as $v) {
        if (pathinfo($v, PATHINFO_EXTENSION) == $fileexts && is_file($v)) {
            file_put_contents($v, iconv($in_charset, $out_charset, file_get_contents($v)));
        }
    }
    return true;
}

/**
 * 列出目录下所有文件
 *
 * @param string $path            
 * @param string $exts            
 * @param array $list            
 * @return array
 *
 */
function dir_list($path, $exts = '', $list = array())
{
    $path = dir_path($path);
    $files = glob($path . '*');
    foreach ($files as $v) {
        if (! $exts || pathinfo($v, PATHINFO_EXTENSION) == $exts) {
            $list[] = $v;
            if (is_dir($v)) {
                $list = dir_list($v, $exts, $list);
            }
        }
    }
    return $list;
}

/**
 * 设置目录下面的所有文件的访问和修改时间
 *
 * @param string $path            
 * @param int $mtime            
 * @param int $atime            
 * @return array true
 *        
 */
function dir_touch($path, $mtime = TIME, $atime = TIME)
{
    if (! is_dir($path))
        return false;
    $path = dir_path($path);
    if (! is_dir($path))
        touch($path, $mtime, $atime);
    $files = glob($path . '*');
    foreach ($files as $v) {
        is_dir($v) ? dir_touch($v, $mtime, $atime) : touch($v, $mtime, $atime);
    }
    return true;
}

/**
 * 目录列表
 *
 * @param string $dir            
 * @param int $parentid            
 * @param array $dirs            
 * @return array
 *
 */
function dir_tree($dir, $parentid = 0, $dirs = array())
{
    global $id;
    if ($parentid == 0)
        $id = 0;
    $list = glob($dir . '*');
    foreach ($list as $v) {
        if (is_dir($v)) {
            $id ++;
            $dirs[$id] = array(
                'id' => $id,
                'parentid' => $parentid,
                'name' => basename($v),
                'dir' => $v . '/'
            );
            $dirs = dir_tree($v . '/', $id, $dirs);
        }
    }
    return $dirs;
}

/**
 * 删除目录及目录下面的所有文件
 *
 * @param string $dir            
 * @return bool TRUE，失败则返回 FALSE
 *        
 */
function dir_delete($dir)
{
    $dir = dir_path($dir);
    if (! is_dir($dir))
        return FALSE;
    $list = glob($dir . '*');
    foreach ($list as $v) {
        is_dir($v) ? dir_delete($v) : @unlink($v);
    }
    return @rmdir($dir);
}

?>