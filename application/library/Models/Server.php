<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Server extends Models_Eloquent
{
    protected $table = 'page_server';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['server_name', 'ip', 'status', 'create_time', 'update_time'];
    /**
     * 检查是否该执行crontab了
     *
     * @param int    $curr_datetime 当前时间
     * @param string $time_str      时间配置
     *
     * @return boolean
     */
    public static function checkTime($curr_datetime, $time_str) {
        $time = explode(' ', $time_str);
        if (count($time) != 5) {
            return false;
        }

        $month = date('n', $curr_datetime); // 没有前导0
        $day = date('j', $curr_datetime); // 没有前导0
        $hour = date('G', $curr_datetime);
        $minute = (int)date('i', $curr_datetime);
        $week = date('w', $curr_datetime); // w 0~6, 0:sunday 6:saturday
        return (self::_isAllow($week, $time[4], 7, 0)
            && self::_isAllow($month, $time[3], 12)
            && self::_isAllow($day, $time[2], 31, 1)
            && self::_isAllow($hour, $time[1], 24)
            && self::_isAllow($minute, $time[0], 60));
    }


    /**
     * 检查是否允许执行
     *
     * @param mixed $needle 数值
     * @param mixed $str 要检查的数据
     * @param int $total_counts 单位内最大数
     * @param int $start 单位开始值（默认为0）
     * @return type
     */
    protected static function _isAllow($needle, $str, $total_counts, $start = 0) {
        // 11:27:25
        // 0 15,16, * * *
        if (strpos($str, ',') !== false) {
            $week_array = explode(',', $str);
            if (in_array($needle, $week_array)) {
                return true;
            }
            return false;
        }
        $array = explode('/', $str);
        $end = $start + $total_counts - 1;
        if (isset($array[1])) {
            if ($array[1] > $total_counts) {
                return false;
            }
            $tmps = explode('-', $array[0]);
            if (isset($tmps[1])) {
                if ($tmps[0] < 0 || $end < $tmps[1]) {
                    return false;
                }
                $start = $tmps[0];
                $end = $tmps[1];
            } else {
                if ($tmps[0] != '*') {
                    return false;
                }
            }
            if (0 == (($needle - $start) % $array[1])) {
                return true;
            }
            return false;
        }
        $tmps = explode('-', $array[0]);
        if (isset($tmps[1])) {
            if ($tmps[0] < 0 || $end < $tmps[1]) {
                return false;
            }
            if ($needle >= $tmps[0] && $needle <= $tmps[1]) {
                return true;
            }
            return false;
        } else {
            if ($tmps[0] == '*' || $tmps[0] == $needle) {
                return true;
            }
            return false;
        }
    }


    /**
     * 替换server_id为另一台server, 目前只有两台server, 以后如果server多了再考虑替换算法
     * @param $current_server_id
     * @param $all_server_ids
     */

    public static function replace_to_another_server($current_server_id, $all_server_ids)
    {
        $ret = '';
        if (!empty($all_server_ids))
        {
            foreach ($all_server_ids as $server_id)
            {
                if ($current_server_id != $server_id)
                {
                    $ret = $server_id;
                    break;
                }
            }
        }
        return $ret;

    }


    /**
     * @param $server_name
     * 主机名字是否合法
     */
    public static function is_valid_name($server_name) {
        $no_tip = '';
        if (empty($server_name)) {
            return '主机名不能为空';
        }
        if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $server_name) > 0) {
            return '主机名中含有中文';
        }

        return $no_tip;

    }

    public static function is_valid_ip($ip) {
        $no_tip = '';
        if (preg_match('/^10\./', $ip) == 0) {
            return 'ip不合法';
        }
        return $no_tip;
    }

    /*
     * server状态显示
     * 0-正常(绿色), 1-异常(红色)
     */
    public static function get_server_status_text($status = 0)
    {
        if ($status == 0) {
            echo '<span style="color:green">正常</span>';
        } else {
            echo '<span style="color:red;">异常</span>';
        }
    }
}