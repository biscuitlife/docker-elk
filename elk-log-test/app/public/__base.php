<?php
session_start();


function uuid(){
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function _log($level,$content = '',$request_id='')
{
    $file = __DIR__ . '/../log/' . date('Y-m-d') . '.log';
    file_put_contents($file,  date('Y-m-d H:i:s') . "[$request_id]" .  '['.strtoupper($level) .']' . ' ' . $content . "\n", 8);
}

function curlPOST($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 5);
    $data = curl_exec($curl);
    curl_close($curl);

//    Log::write('Middleware Response:' . $data);

    return $data;
}

function sendRequest($url, $data = null)
{
    $ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8); //设置超时时间
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
