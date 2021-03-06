<?php
require 'common.php';
// cron调度后台执行程序： demo: php public/cli.php "request_uri=/publish/run"

// 程序启动时间
define('APP_START_TIME', microtime(true));

// 程序根目录
define("APP_PATH",  realpath(dirname(__FILE__) . '/../'));

// 视图目录
define("VIEW_PATH", APP_PATH . '/application/views/');

$app = new Yaf_Application(APP_PATH . "/conf/application.ini");

$request = [];
foreach ($argv as $key => $value) {
    if ($key != 0) {
        parse_str($value, $output);
        $request = array_merge($request, $output);
    }
}

$app = $app->bootstrap()->getDispatcher()->dispatch(new Yaf_Request_Simple());