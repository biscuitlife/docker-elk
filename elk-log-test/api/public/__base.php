<?php
session_start();

function uuid(){
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

class MyLog {
    private $seq_id = 0;
    private $req_id = 0;
    private $file = '';

    public function __construct($req_id, $file = false)
    {
        $this->req_id = $req_id;
        if ($file == false) {
            $this->file =  __DIR__ . '/../log/' . date('Y-m-d') . '.log';
        } else {
            $this->file = $file;
        }
    }

    public function log($level,$content = '')
    {
        $this->seq_id ++;


        file_put_contents($this->file,  date('Y-m-d H:i:s') . "[{$this->req_id} - {$this->seq_id}]" .  '['.strtoupper($level) .']' . ' ' . $content . "\n", 8);
    }
}

function _log($level,$request_id, $content)
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

function _success_log($log)
{
    $log->log('info', '查询生产队列: ' . rand(0,3));
    $log->log('info', '查询生产服务器状态: 空闲');
    $log->log('info', '查询库存数量:' . rand(10, 99));
    $log->log('info', '添加生产队列:成功');
}

/**
 * @param $request_id
 * @param $log MyLog
 */
function _error_log($log)
{
    $i = rand(0,4);
    if ($i == 0) {
        $log->log('info', '查询生产队列: ' . rand(500,999));
        $log->log('error', '生产队列超出限制，创建失败');
        return;
    } else {
        $log->log('info', '查询生产队列: ' . rand(0,500));
    }

    if ($i == 1) {
        $log->log('info',  '查询生产服务器状态: 关机');
        $log->log('error',  '生产服务器状态异常，创建失败');
        return;
    } else {
        $log->log('info',  '查询生产服务器状态: 空闲');
    }

    if ($i == 2) {
        $log->log('info',  '查询库存数量: 0');
        $log->log('error',  '库存数量不足，创建失败');
        return;
    } else {
        $log->log('info',  '查询库存数量:' . rand(10, 99));
    }

    $log->log('info',  '添加生产队列: 失败');
    $log->log('error',  '添加生产队列失败，创建失败');
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

    $curl_errno = curl_errno($ch);
    $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $result = curl_exec($ch);
    curl_close($ch);

    return [
        'result'=>$result,
        'http_code'=>$http_code,
        'curl_errno'=>$curl_errno,
    ];
}
