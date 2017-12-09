<?php

use Illuminate\Database\Capsule\Manager as DB;

class TestController extends Yaf_Controller_Abstract
{


    public function indexAction()
    {

        $session = Yaf_Session::getInstance();
        $session->set('uid', 12);
        $a = $session->get('uid');
        var_dump($a);die;




        $cache = new Cache_Cache();
        $memcache = $cache->connect('Memcache');
        $b = $memcache->set('user_info', false);
        var_dump($b);die;
    }
    // 默认Action
    public function showAction()
    {
        $this->getView()->assign("content", "Hello World");
        $this->getView()->display('index/show.html');
    }

}
