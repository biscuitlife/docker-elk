<?php
include_once '__base.php';

$post = $_POST;
$request_id = uuid();
$log = new MyLog($request_id);


if ( rand(0,3) % 3 == 0) {

    _success_log($log);


    echo json_encode(['code'=>0,'message'=>'success']);
} else {

    $log->log('info', '用户发送过来的数据' . json_encode($post));
    _error_log($log);

    echo json_encode(['code'=>$request_id,'message'=>'API崩溃']);
}
