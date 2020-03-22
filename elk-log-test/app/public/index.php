<?php
include_once '__base.php';

if (!@$_SESSION['user']) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . '/login.php');
    die;
}

echo 'hello, ' . $_SESSION['user'] . "<a href='/logout.php'>logout</a>";

echo "<h1>我的服务器</h1>";
if (isset($_SESSION['servers']) &&!empty($_SESSION['servers'])) {
    echo "<table>";
        echo "<tr><td>操作系统</td><td>规格</td><td>用户</td></tr>";
    foreach ($_SESSION['servers'] as $server) {
        echo "<tr>";
        echo "<td>" . $server['os'] . ",</td>";
        echo "<td>" . $server['spec'] . ",</td>";
        echo "<td>" . $server['user'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

?>

<style>
    input,select{width:200px;height:35px;font-size: 25px;}
    table {
        font-size: 25px;}
</style>
<center>
<form method="post" action="/api.php">
    <h1>创建服务器</h1>
    <table>
        <tr>
            <td>
                用户名:
            </td>
            <td>
                <input name="user" />
            </td>
        </tr>

        <tr>
            <td>
                密码:
            </td>
            <td>
                <input name="pass" type="password" />
            </td>
        </tr>
        <tr>
            <td>
                操作系统:
            </td>
            <td>
                <select name="os">
                    <option value="Windows XP">
                        Windows XP
                    </option>
                    <option value="Windows 7">
                        Windows 7
                    </option>
                    <option value="Windows 8">
                        Windows 8
                    </option>
                    <option value="Windows 10">
                        Windows 10
                    </option>
                    <option value="ubuntu 19.04">
                        ubuntu 19.04
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                规格:
            </td>
            <td>
                <select name="spec">
                    <option value="1c1g">
                        1核1G
                    </option>
                    <option value="2c2g">
                        2核2G
                    </option>
                    <option value="4c8g">
                        4核8G
                    </option>

                </select>
            </td>
        </tr>

        <tr>
            <td>
            </td>
            <td>
            <input value="创建" type="submit" />
            </td>
        </tr>
    </table>
</form>
</center>