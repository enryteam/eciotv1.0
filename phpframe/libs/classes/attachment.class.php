<?php

class attachment
{

    var $contentid;

    var $module;

    var $catid;

    var $attachments;

    var $field;

    var $imageexts = array(
        'gif',
        'jpg',
        'jpeg',
        'png',
        'bmp'
    );

    var $uploadedfiles = array();

    var $downloadedfiles = array();

    var $error;

    var $upload_root;

    var $siteid;

    var $site = array();

    function __construct($module = '', $catid = 0, $siteid = 0, $upload_dir = '')
    {
        $this->catid = intval($catid);
        $this->siteid = intval($siteid) == 0 ? 1 : intval($siteid);
        $this->module = $module ? $module : 'content';
        pc_base::load_sys_func('dir');
        pc_base::load_sys_class('image', '', '0');
        $this->upload_root = pc_base::load_config('system', 'upload_path');
        $this->upload_func = 'copy';
        $this->upload_dir = $upload_dir;
    }

    /**
     * 附件上传方法
     *
     * @param $field 上传字段            
     * @param $alowexts 允许上传类型            
     * @param $maxsize 最大上传大小            
     * @param $overwrite 是否覆盖原有文件            
     * @param $thumb_setting 缩略图设置            
     * @param $watermark_enable 是否添加水印            
     */
    function upload($field, $alowexts = '', $maxsize = 0, $overwrite = 0, $thumb_setting = array(), $watermark_enable = 0)
    {
        if (! isset($_FILES[$field])) {
            $this->error = UPLOAD_ERR_OK;
            return false;
        }
        if (empty($alowexts) || $alowexts == '') {
            $site_setting = $this->_get_site_setting($this->siteid);
            $alowexts = $site_setting['upload_allowext'];
        }
        $fn = $_GET['CKEditorFuncNum'] ? $_GET['CKEditorFuncNum'] : '1';
        
        $this->field = $field;
        $this->savepath = $this->upload_root . $this->upload_dir . date('Y/md/');
        $this->alowexts = $alowexts;
        $this->maxsize = $maxsize;
        $this->overwrite = $overwrite;
        $uploadfiles = array();
        $description = isset($GLOBALS[$field . '_description']) ? $GLOBALS[$field . '_description'] : array();
        if (is_array($_FILES[$field]['error'])) {
            $this->uploads = count($_FILES[$field]['error']);
            foreach ($_FILES[$field]['error'] as $key => $error) {
                if ($error === UPLOAD_ERR_NO_FILE)
                    continue;
                if ($error !== UPLOAD_ERR_OK) {
                    $this->error = $error;
                    return false;
                }
                $uploadfiles[$key] = array(
                    'tmp_name' => $_FILES[$field]['tmp_name'][$key],
                    'name' => $_FILES[$field]['name'][$key],
                    'type' => $_FILES[$field]['type'][$key],
                    'size' => $_FILES[$field]['size'][$key],
                    'error' => $_FILES[$field]['error'][$key],
                    'description' => $description[$key],
                    'fn' => $fn
                );
            }
        } else {
            $this->uploads = 1;
            if (! $description)
                $description = '';
            $uploadfiles[0] = array(
                'tmp_name' => $_FILES[$field]['tmp_name'],
                'name' => $_FILES[$field]['name'],
                'type' => $_FILES[$field]['type'],
                'size' => $_FILES[$field]['size'],
                'error' => $_FILES[$field]['error'],
                'description' => $description,
                'fn' => $fn
            );
        }
        
        if (! dir_create($this->savepath)) {
            $this->error = '8';
            return false;
        }
        if (! is_dir($this->savepath)) {
            $this->error = '8';
            return false;
        }
        @chmod($this->savepath, 0777);
        
        if (! is_writeable($this->savepath)) {
            $this->error = '9';
            return false;
        }
        if (! $this->is_allow_upload()) {
            $this->error = '13';
            return false;
        }
        $aids = array();
        foreach ($uploadfiles as $k => $file) {
            $fileext = fileext($file['name']);
            if ($file['error'] != 0) {
                $this->error = $file['error'];
                return false;
            }
            if (! preg_match("/^(" . $this->alowexts . ")$/", $fileext)) {
                $this->error = '10';
                return false;
            }
            if ($this->maxsize && $file['size'] > $this->maxsize) {
                $this->error = '11';
                return false;
            }
            if (! $this->isuploadedfile($file['tmp_name'])) {
                $this->error = '12';
                return false;
            }
            $temp_filename = $this->getname($fileext);
            $savefile = $this->savepath . $temp_filename;
            $savefile = preg_replace("/(php|phtml|php3|php4|jsp|exe|dll|asp|cer|asa|shtml|shtm|aspx|asax|cgi|fcgi|pl)(\.|$)/i", "_\\1\\2", $savefile);
            $filepath = preg_replace(new_addslashes("|^" . $this->upload_root . "|"), "", $savefile);
            if (! $this->overwrite && file_exists($savefile))
                continue;
            $upload_func = $this->upload_func;
            if (@$upload_func($file['tmp_name'], $savefile)) {
                $this->uploadeds ++;
                @chmod($savefile, 0644);
                @unlink($file['tmp_name']);
                $file['name'] = iconv("utf-8", CHARSET, $file['name']);
                $file['name'] = safe_replace($file['name']);
                $thumb_enable = is_array($thumb_setting) && ($thumb_setting[0] > 0 || $thumb_setting[1] > 0) ? 1 : 0;
                $image = new image($thumb_enable, $this->siteid);
                if ($thumb_enable) {
                    $image->thumb($savefile, '', $thumb_setting[0], $thumb_setting[1]);
                }
                if ($watermark_enable) {
                    $image->watermark($savefile, $savefile);
                }
                $aids[$k] = 'uploadfile/' . $filepath;
            }
        }
        $count = count($aids);
        //if ($count == 1) {
        if (!is_array($_FILES[$field]['error'])) {
		
            return $aids[0];
        }
        return $aids;
    }

    /**
     * 附件下载
     * Enter description here .
     *
     *
     *
     * ..
     *
     * @param $field 预留字段            
     * @param $value 传入下载内容            
     * @param $watermark 是否加入水印            
     * @param $ext 下载扩展名            
     * @param $absurl 绝对路径            
     * @param
     *            $basehref
     */
    function download($field, $value, $watermark = '0', $ext = 'gif|jpg|jpeg|bmp|png', $absurl = '', $basehref = '')
    {
        global $image_d;
        $this->att_db = pc_base::load_model('attachment_model');
        $upload_url = pc_base::load_config('system', 'upload_url');
        $this->field = $field;
        $dir = date('Y/md/');
        $uploadpath = $upload_url . $dir;
        $uploaddir = $this->upload_root . $dir;
        $string = new_stripslashes($value);
        if (! preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i", $string, $matches))
            return $value;
        $remotefileurls = array();
        foreach ($matches[3] as $matche) {
            if (strpos($matche, '://') === false)
                continue;
            dir_create($uploaddir);
            $remotefileurls[$matche] = $this->fillurl($matche, $absurl, $basehref);
        }
        unset($matches, $string);
        $remotefileurls = array_unique($remotefileurls);
        $oldpath = $newpath = array();
        foreach ($remotefileurls as $k => $file) {
            if (strpos($file, '://') === false || strpos($file, $upload_url) !== false)
                continue;
            $filename = fileext($file);
            $file_name = basename($file);
            $filename = $this->getname($filename);
            
            $newfile = $uploaddir . $filename;
            $upload_func = $this->upload_func;
            if ($upload_func($file, $newfile)) {
                $oldpath[] = $k;
                $GLOBALS['downloadfiles'][] = $newpath[] = $uploadpath . $filename;
                @chmod($newfile, 0777);
                $fileext = fileext($filename);
                if ($watermark) {
                    watermark($newfile, $newfile, $this->siteid);
                }
                $filepath = $dir . $filename;
                $downloadedfile = array(
                    'filename' => $filename,
                    'filepath' => $filepath,
                    'filesize' => filesize($newfile),
                    'fileext' => $fileext
                );
                $aid = $this->add($downloadedfile);
                $this->downloadedfiles[$aid] = $filepath;
            }
        }
        return str_replace($oldpath, $newpath, $value);
    }

    /**
     * 附件删除方法
     */
    function delete($filepath)
    {
        $image = $this->upload_root . $filepath;
        @unlink($image);
        $thumbs = glob(dirname($image) . '/*' . basename($image));
        if ($thumbs)
            foreach ($thumbs as $thumb)
                @unlink($thumb);
        return true;
    }

    function set_userid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * 获取缩略图地址..
     *
     * @param $image 图片路径            
     */
    function get_thumb($image)
    {
        return str_replace('.', '_thumb.', $image);
    }

    /**
     * 获取附件名称
     *
     * @param $fileext 附件扩展名            
     */
    function getname($fileext)
    {
        return date('Ymdhis') . rand(100, 999) . '.' . $fileext;
    }

    /**
     * 返回附件大小
     *
     * @param $filesize 图片大小            
     */
    function size($filesize)
    {
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
     * 判断文件是否是通过 HTTP POST 上传的
     *
     * @param string $file            
     * @return bool HTTP POST 上传的则返回 TRUE
     */
    function isuploadedfile($file)
    {
        return is_uploaded_file($file) || is_uploaded_file(str_replace('\\\\', '\\', $file));
    }

    /**
     * 补全网址
     *
     * @param string $surl            
     * @param string $absurl            
     * @param string $basehref            
     * @return string
     */
    function fillurl($surl, $absurl, $basehref = '')
    {
        if ($basehref != '') {
            $preurl = strtolower(substr($surl, 0, 6));
            if ($preurl == 'http://' || $preurl == 'ftp://' || $preurl == 'mms://' || $preurl == 'rtsp://' || $preurl == 'thunde' || $preurl == 'emule://' || $preurl == 'ed2k://')
                return $surl;
            else
                return $basehref . '/' . $surl;
        }
        $i = 0;
        $dstr = '';
        $pstr = '';
        $okurl = '';
        $pathStep = 0;
        $surl = trim($surl);
        if ($surl == '')
            return '';
        $urls = @parse_url(SITE_URL);
        $HomeUrl = $urls['host'];
        $BaseUrlPath = $HomeUrl . $urls['path'];
        $BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/", '/', $BaseUrlPath);
        $BaseUrlPath = preg_replace("/\/$/", '', $BaseUrlPath);
        $pos = strpos($surl, '#');
        if ($pos > 0)
            $surl = substr($surl, 0, $pos);
        if ($surl[0] == '/') {
            $okurl = 'http://' . $HomeUrl . '/' . $surl;
        } elseif ($surl[0] == '.') {
            if (strlen($surl) <= 2)
                return '';
            elseif ($surl[0] == '/') {
                $okurl = 'http://' . $BaseUrlPath . '/' . substr($surl, 2, strlen($surl) - 2);
            } else {
                $urls = explode('/', $surl);
                foreach ($urls as $u) {
                    if ($u == "..")
                        $pathStep ++;
                    else 
                        if ($i < count($urls) - 1)
                            $dstr .= $urls[$i] . '/';
                        else
                            $dstr .= $urls[$i];
                    $i ++;
                }
                $urls = explode('/', $BaseUrlPath);
                if (count($urls) <= $pathStep)
                    return '';
                else {
                    $pstr = 'http://';
                    for ($i = 0; $i < count($urls) - $pathStep; $i ++) {
                        $pstr .= $urls[$i] . '/';
                    }
                    $okurl = $pstr . $dstr;
                }
            }
        } else {
            $preurl = strtolower(substr($surl, 0, 6));
            if (strlen($surl) < 7)
                $okurl = 'http://' . $BaseUrlPath . '/' . $surl;
            elseif ($preurl == "http:/" || $preurl == 'ftp://' || $preurl == 'mms://' || $preurl == "rtsp://" || $preurl == 'thunde' || $preurl == 'emule:' || $preurl == 'ed2k:/')
                $okurl = $surl;
            else
                $okurl = 'http://' . $BaseUrlPath . '/' . $surl;
        }
        $preurl = strtolower(substr($okurl, 0, 6));
        if ($preurl == 'ftp://' || $preurl == 'mms://' || $preurl == 'rtsp://' || $preurl == 'thunde' || $preurl == 'emule:' || $preurl == 'ed2k:/') {
            return $okurl;
        } else {
            $okurl = preg_replace('/^(http:\/\/)/i', '', $okurl);
            $okurl = preg_replace('/\/{1,}/i', '/', $okurl);
            return 'http://' . $okurl;
        }
    }

    /**
     * 是否允许上传
     */
    function is_allow_upload()
    {
        if ($_groupid == 1)
            return true;
        $starttime = SYS_TIME - 86400;
        $site_setting = $this->_get_site_setting($this->siteid);
        return ($uploads < 2048);
    }

    /**
     * 返回错误信息
     */
    function error()
    {
        $UPLOAD_ERROR = array(
            0 => L('att_upload_succ'),
            1 => L('att_upload_limit_ini'),
            2 => L('att_upload_limit_filesize'),
            3 => L('att_upload_limit_part'),
            4 => L('att_upload_nofile'),
            5 => '',
            6 => L('att_upload_notemp'),
            7 => L('att_upload_temp_w_f'),
            8 => L('att_upload_create_dir_f'),
            9 => L('att_upload_dir_permissions'),
            10 => L('att_upload_limit_ext'),
            11 => L('att_upload_limit_setsize'),
            12 => L('att_upload_not_allow'),
            13 => L('att_upload_limit_time')
        );
        
        return iconv(CHARSET, "utf-8", $UPLOAD_ERROR[$this->error]);
    }

    /**
     * ck编辑器返回
     *
     * @param
     *            $fn
     * @param $fileurl 路径            
     * @param $message 显示信息            
     */
    function mkhtml($fn, $fileurl, $message)
    {
        $str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $fn . ', \'' . $fileurl . '\', \'' . $message . '\');</script>';
        exit($str);
    }

    /**
     * flash上传调试方法
     *
     * @param
     *            $id
     */
    function uploaderror($id = 0)
    {
        file_put_contents(PHPFRAME_PATH . 'xxx.txt', $id);
    }

    /**
     * 获取站点配置信息
     *
     * @param $siteid 站点id            
     */
    private function _get_site_setting($siteid)
    {
        $siteinfo = pc_base::load_config('sitelist');
        return string2array($siteinfo[$siteid]['setting']);
    }
}
?>
