<?php
/**
 * lsnphp框架扩展类
 * 
 * 文件上传封装类
 * 
 * lsnphp框架下使用方法：
 * 
 	include_once ( "lpFileUpload.php" );
 	$options = array (
			'filepath' => MESSAGE_dir,
			'allowtype' => array (
					'doc',
					'docx' 
			),
			'maxsize' => '2000000',
			'israndname' => 'true' 
	);
 	$file = lpClass("lpFileUpload", array( $options ));
	$rs = $file->uploadFile ( 'file' );
	if ($rs) {
		$fileNewName = $file->getNewFileName ();
	} else {
		$msg = $file->getErrorMsg ();
	}
 * 
 * @author  Zhaohj
 * 2013-6-27
 */
class lpFileUpload {

	/**
	 * 指定上传文件保存的路径
	 */
	private $filepath;

	/**
	 * 充许上传文件的类型
	 */
	private $allowtype = array (
			'gif',
			'jpg',
			'png',
			'jpeg' 
	);

	/**
	 * 允上传文件的最大长度，默认大小1M
	 */
	private $maxsize = 1000000;

	/**
	 * 是否随机重命名， false不随机，使用原文件名
	 */
	private $israndname = true;

	/**
	 * 源文件名称
	 */
	private $originName;

	/**
	 * 临时文件名
	 */
	private $tmpFileName;

	/**
	 * 文件类型
	 */
	private $fileType;

	/**
	 * 文件大小
	 */
	private $fileSize;

	/**
	 * 新文件名
	 */
	private $newFileName;

	/**
	 * 错误号
	 */
	private $errorNum = 0;

	/**
	 * 用来提供错误报告
	 */
	private $errorMess = "";

	/**
	 * 上传文件初始化
	 * 
	 * @param unknown $options 设置参数
	 * 	1. 指定上传路径， 2，充许的类型， 3，限制大小， 4，是否使用随机文件名称
	 */
	function __construct($options = array()) {
		foreach ( $options as $key => $val ) {
			$key = strtolower ( $key );
			// 查看用户参数中数组的下标是否和成员属性名相同
			if (! in_array ( $key, get_class_vars ( get_class ( $this ) ) )) {
				continue;
			}
			$this->setOption ( $key, $val );
		}
	}

	/**
	 * 获取错误代号
	 * 
	 * @return string 返回错误信息
	 */
	private function getError() {
		$str = "上传文件{$this->originName}时出错：";
		switch ($this->errorNum) {
			case 4 :
				$str .= "没有文件被上传";
				break;
			case 3 :
				$str .= "文件只被部分上传";
				break;
			case 2 :
				$str .= "上传文件超过了HTML表单中MAX_FILE_SIZE选项指定的值";
				break;
			case 1 :
				$str .= "上传文件超过了php.ini 中upload_max_filesize选项的值";
				break;
			case - 1 :
				$str .= "未允许的类型";
				break;
			case - 2 :
				$str .= "文件过大，上传文件不能超过{$this->maxsize}个字节";
				break;
			case - 3 :
				$str .= "上传失败";
				break;
			case - 4 :
				$str .= "建立存放上传文件目录失败，请重新指定上传目录";
				break;
			case - 5 :
				$str .= "必须指定上传文件的路径";
				break;
			default :
				$str .= "末知错误";
		}
		return $str;
	}

	/**
	 * 检查文件上传路径
	 * 
	 * @return boolean
	 */
	private function checkFilePath() {
		if (empty ( $this->filepath )) {
			$this->setOption ( 'errorNum', - 5 );
			return false;
		}
		if (! file_exists ( $this->filepath ) || ! is_writable ( $this->filepath )) {
			if (! @mkdir ( $this->filepath, 0755 )) {
				$this->setOption ( 'errorNum', - 4 );
				return false;
			}
		}
		return true;
	}

	/**
	 * 检查文件上传大小
	 * 
	 * @return boolean
	 */
	private function checkFileSize() {
		if ($this->fileSize > $this->maxsize) {
			$this->setOPtion ( 'errorNum', '-2' );
			return false;
		} else {
			return true;
		}
	}

	/**
	 * 检查文件上传类型
	 * 
	 * @return boolean
	 */
	private function checkFileType() {
		if (in_array ( strtolower ( $this->fileType ), $this->allowtype )) {
			return true;
		} else {
			$this->setOption ( 'errorNum', - 1 );
			return false;
		}
	}

	/**
	 * 设置上传后的文件名称
	 * 
	 */
	private function setNewFileName() {
		if ($this->israndname) {
			$this->setOption ( 'newFileName', $this->proRandName () );
		} else {
			$this->setOption ( 'newFileName', $this->originName );
		}
	}

	/**
	 * 设置随机文件名称
	 * @return string
	 */
	private function proRandName() {
		$fileName = time() . "_" . rand ( 1000, 9999 );
		return $fileName . '.' . $this->fileType;
	}

	private function setOption($key, $val) {
		$this->$key = $val;
	}

	/**
	 * 上传文件函数
	 * @param unknown $fileField
	 * @return boolean
	 */
	function uploadFile($fileField) {
		$return = true;
		// 检查文件上传路径
		if (! $this->checkFilePath ()) {
			$this->errorMess = $this->getError ();
			return false;
		}
		$name = $_FILES [$fileField] ['name'];
		$tmp_name = $_FILES [$fileField] ['tmp_name'];
		$size = $_FILES [$fileField] ['size'];
		$error = $_FILES [$fileField] ['error'];
		if (is_Array ( $name )) {
			$errors = array ();
			for($i = 0; $i < count ( $name ); $i ++) {
				if ($this->setFiles ( $name [$i], $tmp_name [$i], $size [$i], $error [$i] )) {
					if (! $this->checkFileSize () || ! $this->checkFileType ()) {
						$errors [] = $this->getError ();
						$return = false;
					}
				} else {
					$error [] = $this->getError ();
					$return = false;
				}
				if (! $return)
					$this->setFiles ();
			}
			if ($return) {
				$fileNames = array ();
				for($i = 0; $i < count ( $name ); $i ++) {
					if ($this->setFiles ( $name [$i], $tmp_name [$i], $size [$i], $error [$i] )) {
						$this->setNewFileName ();
						if (! $this->copyFile ()) {
							$errors = $this->getError ();
							$return = false;
						} else {
							$fileNames [] = $this->newFileName;
						}
					}
				}
				$this->newFileName = $fileNames;
			}
			$this->errorMess = $errors;
			return $return;
		} else {
                    
			if ($this->setFiles ( $name, $tmp_name, $size, $error )) {
				if ($this->checkFileSize () && $this->checkFileType ()) {
					$this->setNewFileName ();
					if ($this->copyFile ()) {
						return true;
					} else {
						$return = false;
					}
				} else {
					$return = false;
				}
			} else {
				$return = false;
			}
			if (! $return)
				$this->errorMess = $this->getError ();
			return $return;
		}
	}

	private function copyFile() {
		if (! $this->errorNum) {
			$filepath = rtrim ( $this->filepath, '/' ) . '/';
			$filepath .= $this->newFileName;
			if (move_uploaded_file ( $this->tmpFileName, $filepath )) {
				return true;
			} else {
				$this->setOption ( 'errorNum', - 3 );
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * 设置和$_FILES有关的内容
	 * 
	 * @param string $name
	 * @param string $tmp_name
	 * @param number $size
	 * @param number $error
	 * @return boolean
	 */
	private function setFiles($name = "", $tmp_name = '', $size = 0, $error = 0) {
		$this->setOption ( 'errorNum', $error );
		if ($error) {
			return false;
		}
		$this->setOption ( 'originName', $name );
		$this->setOption ( 'tmpFileName', $tmp_name );
		$arrStr = explode ( '.', $name );
		$this->setOption ( 'fileType', strtolower ( $arrStr [count ( $arrStr ) - 1] ) );
		$this->setOption ( 'fileSize', $size );
		return true;
	}

	/**
	 * 用于获取上传后文件的文件名
	 * 
	 * @return multitype:NULL
	 */
	function getNewFileName() {
		return $this->newFileName;
	}

	/**
	 * 上传如果失败，则调用这个方法，就可以查看错误报告
	 * @return string
	 */
	function getErrorMsg() {
		return $this->errorMess;
	}
}
?>