<?php


class Tool
{

    /**
     * @return string
     * swoole获取内网ip
     */
    public static function get_server_ip()
    {
        $ips =  array_values(\swoole_get_local_ip());
        if (isset($ips[0])) {
            return $ips[0];
        }
        return '127.0.0.1';
    }

    public static function get_int_server_ip()
    {
        $cmd = "ifconfig|grep inet|grep -v \"127.0.0.1\"|awk '{print substr(\$2, 6)}'|grep -E \"^172.|^10.\"";
        $value = shell_exec($cmd);
        var_dump($value);die;
        $ips = explode("\n", trim($value));
        if (isset($ips[0])) {
            return $ips[0];
        }
        return '127.0.0.1';
    }

    public static function filter_by_field($data, $filed)
    {
        $ret = array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                isset($value[$filed]) && $ret[] = $value[$filed];
            }
        }
        return $ret;
    }



    public static function get_milli_second()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }


    public static function encoder($data)
    {
        echo json_encode($data);
    }



    public static function cookie_encode($value) {
        $key =  getConfig('cookie', 'key');
        $key     = sha1($key);  //随机加密字符，可以多重加密，越复杂越好
        $temp     = $value ^ $key;
        return base64_encode($temp);
    }

    //cookie解密
    public static function cookie_decode($value) {
        $key =  getConfig('cookie', 'key');
        $key     = sha1($key);
        $temp     = base64_decode($value);
        return $temp ^ $key;
    }


}
