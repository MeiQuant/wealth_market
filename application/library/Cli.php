<?php

class Cli
{
    const COLOR_BLACK = '30'; // 黑色
    const COLOR_RED = '31';  // 红
    const COLOR_GREE = '32'; // 绿
    const COLOR_YELLOW = '33';  // 黄
    const COLOR_BLUE = '34';  // 蓝
    const COLOR_PURPLE = '35';  // 紫
    const COLOR_SBLUE = '36'; // 深绿
    const COLOR_WHITE = '37'; // 白色

    protected static $color_to_type = array(
        'normal' => self::COLOR_SBLUE,
        'warning' => self::COLOR_YELLOW,
        'error' => self::COLOR_RED
    );

    protected static $log = '/tmp/b.log';

    public static function msg($title, $msg, $type = 'normal', $write_log = true) {
        $result = '';
        $color = self::$color_to_type[$type];
        if($color) {
            $result .= "\033[{$color}m";
        }

        $result .= '[' . $title . '] ';

        if($color) {
            $result .= "\033[0m";
        }

        $result .= $msg;
        echo $result . ' ,时间为' . date('Y-m-d H:i:s') . "\n";

        if ($write_log) {
            error_log($result . ' ,时间为' . date('Y-m-d H:i:s') . "\n", 3, self::$log);
        }
    }


}
