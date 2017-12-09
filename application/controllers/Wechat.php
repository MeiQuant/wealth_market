<?php

use Illuminate\Database\Capsule\Manager as DB;
use EasyWeChat\Foundation\Application;


class WechatController extends Yaf_Controller_Abstract
{

    public $_valid = null;

    public $_options = array();


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

        $this->_options = $options;


    }

    public function validAction()
    {
        $app = $this->_app;
        $server = $app->server;
        $server->setMessageHandler(function ($message) {
            $user = $message->FromUserName; //用户的open_id
            if (isset($message->Event) && $message->Event == 'subscribe')
            {
                return '尊敬的用户您好，123';
            }
        });

        $response = $server->serve();

        // 将响应输出
        $response->send();

    }


    /**
     * 更新微信底部的菜单
     */
    public function menuAction()
    {
        $app = $this->_app;
        $menu_api = $app->menu;

        $buttons = [
            [
                "type" => "view",
                "name" => "有恒财富新闻",
                "url"  => "http://wealth-market.smallwolf.cn/index/show"
            ],
//            [
//                "name"       => "咨询中心",
//                "sub_button" => [
//                    [
//                        "type" => "view",
//                        "name" => "个人诊所",
//                        "url"  => "http://221.232.160.226/xygs3/search.html"
//                    ],
//                    [
//                        "type" => "view",
//                        "name" => "咨询中心",
//                        "url"  => "http://weixin.xyzq.com.cn/weixinpost/zxzx/index.html"
//                    ]
//                ],
//            ],
//
        ];
        $response = $menu_api->add($buttons);
        var_dump($response);
    }


    public function oauthcallbackAction()
    {
        $this->_app = new Application($this->_options);
        $oauth = $this->_app->oauth;
        $user = $oauth->user();
        $info = $user->getOriginal();
        $open_id = $info['openid'];
        if (!empty($info) && is_array($info)) {
            // 不设计到交易， 登录等敏感信息， 不用加密了
            $ret = setcookie('uid', $open_id, time() + 24 * 3600, '/');
            $is_register_user = DB::table('finance_user')->where('open_id', $info['openid'])->select('id')->first();
            if (empty($is_register_user)) {
                $datetime = date('Y-m-d H:i:s', time());
                $ret = DB::table('finance_user')->insert([
                    ['nickname' => $info['nickname'], 'province' => $info['province'], 'city' => $info['city'], 'headimgurl' => $info['headimgurl'] ,'open_id' => $info['openid'], 'create_time' => $datetime, 'update_time' => $datetime]
                ]);

                if ($ret === false) {
                    DB::table('finance_user')->insert([
                        ['nickname' => $info['nickname'], 'province' => $info['province'], 'city' => $info['city'], 'headimgurl' => $info['headimgurl'] ,'open_id' => $info['openid'], 'create_time' => $datetime, 'update_time' => $datetime]
                    ]);
                }
            }

            header('location:'. '/index/show?id=' . $info['openid'] . '#mp.weixin.qq.com');
        }
    }

}
