<?php
//require 'common.php';
//// cron调度后台执行程序： demo: php cli.php "request_uri=/daemon/process"
//
//// 程序启动时间
//define('APP_START_TIME', microtime(true));
//
//// 程序根目录
//define("APP_PATH",  realpath(dirname(__FILE__) . '/../'));
//
//// 视图目录
//define("VIEW_PATH", APP_PATH . '/application/views/');
//
//$app = new Yaf_Application(APP_PATH . "/conf/application.ini");



$server = new swoole_server("10.210.241.170", 9503);
$server->set(
    array(
        'dispatch_mode' => 2
    )
);
$server->on('connect', function ($serv, $fd) use ($server){
    echo 'connect';
});

$process = new swoole_process(function($process) use ($server) {
    //
});

$server->addProcess($process);


$server->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, 'srv2: '.$data);
//    $serv->close($fd);
});

//        $server->on('request', function ($request, $response) {
//            $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
//        });

$server->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

$server->start();

//$request = [];
//foreach ($argv as $key => $value) {
//    if ($key != 0) {
//        parse_str($value, $output);
//        $request = array_merge($request, $output);
//    }
//}
//
//$app = $app->bootstrap()->getDispatcher()->dispatch(new Yaf_Request_Simple());