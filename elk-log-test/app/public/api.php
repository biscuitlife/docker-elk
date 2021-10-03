<?php
include_once '__base.php';

$data = @$_POST;

_log('info', '提交到API的数据:' . json_encode($data));

$result = sendRequest('http://localhost:9090',$data);

_log('info', '从API接受的数据:' . $result);

$result = json_decode($result, true);

if ($result['code'] == 0) {
    echo "您的服务器已经创建成功," . '<a href="/index.php">点击返回列表</a>';
} else {
    echo "您的服务器已经创建失败,错误号:" . $result['code'] . '<a href="/index.php">点击返回列表</a>';
}





