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

    public $_js_sdk;

    public $_is_from_share = false; // 是否通过分享出来的链接

    public $_redis = null;

    public $_device = 'ios';

    /**
     * 微信端基类控制器, 定时获取用户open_id, 暂时未进行加密处理
     */
    public function init()
    {
        header("Content-Type:text/html;charset=utf-8");

        $this->_device = get_device_type();

        $url = $_SERVER['REQUEST_URI'];
        $refer_url = urlencode($url);
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
                'callback' => 'http://wealth-market.smallwolf.cn/wechat/oauthcallback?refer=' . $refer_url
            ],
        ];

        $this->_app = new Application($options);

        $this->_redis = Cache_Cache::getInstance('Redis');

        if (DEBUG) {
            $this->_uid = 'oQt5h03tsXD7Wn6wWqzYDJ0umbEk';
            return ;
        }

        $open_id = (isset($_COOKIE['uid']) && !empty($_COOKIE['uid'])) ? $_COOKIE['uid'] : false;
        $open_id = Tool::cookie_decode($open_id);
        if ($open_id == 'oQt5h0wz8SXSBN1MYMT7_D-oFzAA')
        {
            // 测试账号，测试微信授权登录回调函数
            $open_id = '';
        }
        if (!empty($open_id)) {
            $user = DB::table('finance_user')->where('open_id', $open_id)->first();
            if (empty($user)) {
                // 容错处理, 防止微信客户端有cookie, 但是数据库没信息
                $open_id = false;
            }
        }
        if (empty($open_id))
        {
            $oauth = $this->_app->oauth;
            // 发起微信端的授权
            echo $oauth->redirect()->send();
        }
        else
        {
            $this->_uid = $open_id;
//            if (strpos($_SERVER['REQUEST_URI'], '%23mp.weixin.qq.com') === false && strpos($_SERVER['REQUEST_URI'], '#mp.weixin.qq.com') === false) {
//                header("location: ". $_SERVER['REQUEST_URI'] . urlencode("#mp.weixin.qq.com"));
//            }
        }

    }


    public function filter_param($field, $type = 'get')
    {


        $param = isset($_GET[$field]) ? $_GET[$field] : '';
        $param = trim($param);
        if (!empty($param)) {
            if (strpos(urldecode($param), '#') !== false) {
                $param = explode('#', urldecode($param))[0];
            }
        }
        return $param;
    }


}
