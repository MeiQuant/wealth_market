<?php

use EasyWeChat\Foundation\Application;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * Class AbstractController
 */
abstract class IndexabstractController extends Yaf_Controller_Abstract
{

    public $_app = null;

    public $_callback_request_uri = '';

    public $_memcache = null;

    public $_uid = '';
    /**
     * 微信端基类控制器, 定时获取用户open_id, 暂时未进行加密处理
     */
    public function init()
    {
        if (DEBUG) {
            $this->_uid = 'oQt5h03tsXD7Wn6wWqzYDJ0umbEk';
            return ;
        }
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
        $this->_memcache = $memcache;
        $open_id = isset($_COOKIE['uid']) ? $_COOKIE['uid'] : false;
        if (!empty($open_id)) {
            $user = DB::table('finance_user')->where('open_id', $open_id)->first();
            if (empty($user)) {
                // 容错处理, 防止微信客户端有cookie, 但是数据库没信息
                $open_id = false;
            }
        }
        if (empty($open_id))
        {
            $this->_app = new Application($options);
            $oauth = $this->_app->oauth;
            // 发起微信端的授权
            echo $oauth->redirect()->send();
        }
        else
        {
            $this->_uid = $open_id;
            if (strpos($_SERVER['REQUEST_URI'], '%23mp.weixin.qq.com') === false && strpos($_SERVER['REQUEST_URI'], '#mp.weixin.qq.com') === false) {
                header("location: ". $_SERVER['REQUEST_URI'] . urlencode("#mp.weixin.qq.com"));
            }
        }

    }


}
