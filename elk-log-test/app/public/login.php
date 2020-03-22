<?php
include_once '__base.php';

if (@$_SESSION['user']) {
    header("Location: http://" . $_SERVER['HTTP_HOST']);
    exit;
} else {
    if (@$_POST['user'] == 'admin' && @$_POST['pass'] == 'admin') {
        $_SESSION['user'] = 'admin';

        _log('info', '用户登录:登录名：' . $_POST['user']);

        header("Location: http://" . $_SERVER['HTTP_HOST']);
        exit;
    } else if (@$_POST['user'] && @$_POST['pass']) {
        _log('info', '用户登录失败:登录名：' . $_POST['user'] . ',密码:' . $_POST['pass']);
    }
}


?>
<style>
    input,select{width:200px;height:35px;font-size: 25px;}
    table {
        font-size: 25px;}</style>
<center>
<form action="/login.php" method="post">
    <table>
        <tr>
            <td>user:</td>
            <td><input name="user" /></td>
        </tr>
        <tr>
            <td>pass:</td>
            <td><input name="pass" type="password"/><br/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="login"/></td>
        </tr>
    </table>

</form>
</center>