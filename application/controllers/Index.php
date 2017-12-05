<?php

use Illuminate\Database\Capsule\Manager as DB;

class IndexController extends IndexabstractController
{

    public function init()
    {
        $this->_callback_request_uri = $_SERVER['REQUEST_URI'];
        parent::init();
    }

    public function indexAction()
    {
        $this->redirect('/admin/index');
    }
    // 默认Action
    public function showAction()
    {
        $this->getView()->assign("content", "Hello World");
        $this->getView()->display('index/show.html');
    }

}
