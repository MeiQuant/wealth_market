<?php


use Illuminate\Database\Capsule\Manager as DB;
use EasyWeChat\Foundation\Application;


class WechatController extends AbstractController
{

    public $_valid = null;

    public $_app;

    public function init()
    {
        parent::init();
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
                'callback' => 'http://wxxncf.xyzq.cn/index/user/index'
            ],
        ];

        $this->_app = new Application($options);
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
                "url"  => "http://wealth-market.smallwolf.cn/new/index"
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

}
