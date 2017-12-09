<?php
/**
 * URI重定向插件
 *
 * @package plugin
 * @author hongjun6 <hongjun6@staff.sina.com.cn>
 * @date 2017/12/8
 */
class RouterPlugin extends Yaf_Plugin_Abstract {


    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $action = $request->getActionName();
        $action = urldecode($action);
        // 微信安卓版本调用手机电话的时候url后必须加上qq.com的耳机域名
        if (strpos($action, '#') !== false) {
            $action = explode('#', $action)[0];
        }
        $request->setActionName($action);
        $request->setDispatched();
    }

}
