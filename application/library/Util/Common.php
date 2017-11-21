<?php

class Util_Common
{
    public static function get($field, $if_not_exist = '')
    {
        return isset($_GET[$field]) ? trim($_GET[$field]) : $if_not_exist;
    }

    public static function post($field, $if_not_exist = '')
    {
        return isset($_POST[$field]) ? trim($_POST[$field]) : $if_not_exist;
    }

    public static function get_login_user_id()
    {
        $user = Ldap::getUser();
        return isset($user['id']) ? $user['id'] : '';
    }
}