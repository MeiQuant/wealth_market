<?php

class Config
{
    protected static $_config_data = array();

    public static function load($file, $path_prefix = 'config', $to_array = true)
    {
        $key = $path_prefix . ':' . $file;
        if (!isset(self::$_config_data[$key])) {
            $config_file = ROOTPATH . DIRECTORY_SEPARATOR . $path_prefix . DIRECTORY_SEPARATOR . $file . '.ini';
            self::$_config_data[$key] = new \Yaf_Config_Ini($config_file);
        }
        return $to_array ? self::$_config_data[$key]->toArray() : self::$_config_data[$key];
    }
}
