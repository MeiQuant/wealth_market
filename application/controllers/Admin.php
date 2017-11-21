<?php


use Illuminate\Database\Capsule\Manager as DB;

class AdminController extends AbstractController
{

    public $need_login = true;

    public function init()
    {
        parent::init();
    }
    public function indexAction()
    {
        $this->getView()->assign("title", "后台首页");
        $this->getView()->assign("content", "Hello World");
        $this->getView()->display('admin/index.html');
    }

}
