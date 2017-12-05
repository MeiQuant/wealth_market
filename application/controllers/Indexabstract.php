<?php

use EasyWeChat\Foundation\Application;

/**
 * Class AbstractController
 */
abstract class IndexabstractController extends Yaf_Controller_Abstract
{

    public $_app = null;

    public $_callback_request_uri = '';

    public $_memcache = null;

    /**
     * 微信端基类控制器, 定时获取用户open_id, 暂时未进行加密处理
     */
    public function init()
    {
        header("Content-Type:text/html;charset=utf-8");
        $options = [
            'debug'  => true,
            'app_id' => 'wx40d7d5323c90b1b1',
            'secret' => 'f2dff7bf51644e035fe0c2513998d1db',
            'token'  => '159357',
            // 'aes_key' => null, // 可选
            'log' => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log', // XXX: 绝对路径！！！！
            ],
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => 'http://wealth-market.smallwolf.cn/wechat/oauthcallback'
            ],
        ];


        $cache = new Cache_Cache();
        $memcache = $cache->connect('Memcache');
        $user_info = $memcache->get('user_info');

        $this->_memcache = $memcache;
        if (empty($user_info))
        {
            $this->_app = new Application($options);
            $oauth = $this->_app->oauth;
            // 发起微信端的授权
            echo $oauth->redirect()->send();
        } else {
            if (strpos($_SERVER['QUERY_STRING'], 'id=') === false) {
                $user_info = json_decode($user_info, true);
                $id = $user_info['openid'];
                header('Location: /index/show?id=' . $id);
            }

        }

    }


}
