<?php
include_once '__base.php';

$user = $_SESSION['user'];

if ($user) {
    $_SESSION['user'] = "";
    $_SESSION['servers'] = [];
    _log('info', "用户[" . $user . ']于'.date('Y-m-d H:i:s').'退出登录' );
}




echo "用户" . $user . '已退出登录' . ',<a href="/login.php">返回登录</a>';