<?php

/**
 * Class Validation
 * 验证类的统一入口
 */

class Validation
{

    private static $_instance = NULL;

    public $transfer_data;

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    static public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function set_fields($data)
    {
        $this->transfer_data = $data;
    }

    public function get_fields()
    {
        return $this->transfer_data;
    }


    /**
     * @param $class_name
     * @param $methods
     * @return bool
     */
    public function valid($class_name, $methods)
    {
        //array('name' => 'is_valid_name', 'ip' => 'is_valid_ip')
        $valid = true;
        $msg = '';
        if (empty($class_name) || empty($methods)) {
            return false;
        }

        if (is_array($methods)) {
            foreach ($methods as $filed => $method) {
                $ret = call_user_func_array(array($class_name, $method), array($this->transfer_data[$filed]));
                if (!empty($ret)) {
                    $valid = false;
                    $msg = $ret;
                    break;
                }
            }
        }

        return array(
            'status' => $valid,
            'msg' => $msg
        );
    }


}
