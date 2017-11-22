<?php


use Illuminate\Database\Capsule\Manager as DB;

class LoginController extends AbstractController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $username = Util_Common::post('username');
            $password = Util_Common::post('password');


            if (!in_array($username, $this->members))
            {
                _error_json_encoder('用户名不在白名单之内');
            }


            if (empty($username) || empty($password)) {
                _error_json_encoder('用户名或者密码不能为空');
            }

            $login = Models_Login::login($username, $password);
            if (!$login) {
                _error_json_encoder('用户名或者密码不正确');
            } else {
                _success_json_encoder('登录成功');
            }
        }
        $this->getView()->assign("content", "Hello World");
        $this->getView()->display('login/index.html');
    }

    public function logoutAction()
    {
        if (Ldap::logoutUser())
        {
            $this->redirect('/login/index');
        }
    }


}
