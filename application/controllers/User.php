<?php


use Illuminate\Database\Capsule\Manager as DB;

class UserController extends AbstractController
{

    public $_valid = null;

    public $need_login = true;

    public function init()
    {
        $this->_valid = Validation::getInstance();
        parent::init();
    }

    /**
     * 管理员
     */
    public function indexAction()
    {
        $this->getView()->assign("title", "管理员");
        $this->getView()->assign('page_users', implode(', ', $this->page_members));
        $this->getView()->display('user/index.html');
    }




}
