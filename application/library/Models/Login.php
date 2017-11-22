<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Login
{

    public static function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            return false;
        }

        $username = trim($username);
        $password = trim($password);

        $userInfo = Ldap::loginUser($username, $password);

        if ($userInfo)
        {
            return true;
        }

        return false;
    }

}