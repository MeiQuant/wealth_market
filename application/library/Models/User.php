<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_User extends Models_Eloquent
{
    protected $table = 'finance_user';



    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['username', 'nickname', 'headimgurl', 'phone', 'email', 'introduce', 'company', 'job', 'province', 'city', 'code', 'open_id', 'create_time', 'update_time'];


    public static function is_valid_phone($phone) {
        $no_tip = '';
        if (empty($phone)) {
            return '手机号码不能为空';
        }

        if (!preg_match("/^1[34578]{1}\d{9}$/", $phone)) {
            return '手机号码格式不正确';
        }
        return $no_tip;
    }


    public static function is_valid_email($email) {
        $no_tip = '';
        if (!empty($email)) {
            $mode = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
            if (!preg_match($mode, $email)) {
                return '邮箱格式不对';
            }
        }

        return $no_tip;
    }



}