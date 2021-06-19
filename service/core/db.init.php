<?php
$conf = include_once("/eciot/htdocs/configs/database.php");
$conn = new mysqli($conf['default']['hostname'],$conf['default']['username'],$conf['default']['password'],$conf['default']['database']);

if(mysqli_connect_errno()) {
	printf("Connect failed: ",mysqli_connect_errno());
	exit();
}
mysqli_query($conn,"set names 'utf8'");
set_time_limit(0);

//多条数据查询
function query($sql,$conn)
{
  $rows = array();
	$result = mysqli_query($conn,$sql);
	if($result){
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			$rows[]=$row;
		}
		return $rows;
	}else{
		return false;
	}
}

//单条数据查询
function queryone($sql,$conn)
{
	$sql = $sql . ' limit 1';
	$result = mysqli_query($conn,$sql);
	if($result){
		$row = mysqli_fetch_array($result, MYSQL_ASSOC);
		return $row;
	}else{
		return false;
	}
}

//执行语句
function querysql($sql,$conn)
{
	$result = mysqli_query($conn,$sql);
  return $result;
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

function get_head($url)
{
    $header = [
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:45.0) Gecko/20100101 Firefox/45.0',
        'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
        'Accept-Encoding: gzip, deflate',
    ];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $data = curl_exec($curl);
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($code == 200) {//把URL格式的图片转成base64_encode格式的！
        $imgBase64Code = base64_encode($data);
        return $imgBase64Code;//图片内容
    } else {
        return '获取头像失败';
    }
}


