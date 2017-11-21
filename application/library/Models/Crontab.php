<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Crontab extends Models_Eloquent
{

    protected $table = 'page_crontab';

    public $timestamps = false;

    protected $fillable = ['name', 'timer', 'exec_file', 'args', 'redirect', 'timeout', 'server_id', 'repeat_num', 'exit_code', 'process_restart_type', 'master_pid', 'timeout_kill_type', 'status', 'start_time', 'finish_time'];

    protected static $kill_signal_type = array(
        9 => SIGKILL,
        15 => SIGTERM
    );

    const EXEC_FILE = '/usr/local/sinasrv2/bin/php';

    // 关联server表
    public function server()
    {
        return $this->belongsTo('Models_Server', 'server_id');
    }

    public static function get_cron_status($cron) {
        if (!empty($cron['process_restart_type']))
        {
            return $cron['process_restart_type'] == PROCESS_MANUAL_RESTART ? '<span style="color:red;font-weight: bold;">等待手动重启</span>' : '<span style="color:red;font-weight: bold;">等待自动重启</span>';
        }

        if (!empty($cron['exit_code']))
        {
            return '<span style="color:blue;font-weight: bold;">等待自动重启</span>';
        }

        return '<span style="color:green;font-weight: normal;">正常</span>';
    }
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
     * @param $server_name
     * cron名字是否合法
     */
    public static function is_valid_name($cron_name) {
        $no_tip = '';
        if (empty($cron_name)) {
            return '名字不能为空';
        }
        return $no_tip;

    }

    /**
     * @param $timer
     * @return string
     */
    public static function is_valid_timer($timer) {
        $no_tip = '';
        if (empty($timer)) {
            return '执行时间格式不能为空';
        }

        $timer = trim($timer);
        $timer_array = explode(' ', $timer);
        if (count($timer_array) != 5) {
            return '执行时间格式必须为5个时间段';
        }
        return $no_tip;

    }

    /**
     * @param $exec_file
     * @return string
     * 可执行文件
     */
    public static function is_valid_exec_file($exec_file) {
        $no_tip = '';
        if (empty($exec_file)) {
            return '可执行文件不能为空';
        }

        $exec_file = trim($exec_file);
        if (!is_executable($exec_file)) {
            return "{$exec_file}不是正确的可执行文件";
        }

        if ($exec_file != self::EXEC_FILE)
        {
            return '可执行文件的路径不对';
        }

        return $no_tip;

    }


    public static function is_valid_args($args) {
        $no_tip = '';
        if (empty($args)) {
            return '参数(php文件)不能为空';
        }
        return $no_tip;
    }


    public static function is_valid_redirect($redirect) {
        $no_tip = '';
        return $no_tip;
    }

    public static function is_valid_server($server_id) {
        $no_tip = '';
        if (empty($server_id)) {
            return '队列机不能为空';
        }

        $server_id_array = explode(',', $server_id);
        $server_id_data = Models_Server::where('status', 0)->whereIn('id', $server_id_array)->get();
        if (count($server_id_array) !== count($server_id_data)) {
            return '队列机的ip不合法';
        }
        return $no_tip;
    }

    public static function is_valid_timeout_kill_type($timeout_kill_type)
    {
        $no_tip = '';
        if (!in_array($timeout_kill_type, array(SIGKILL, SIGTERM)))
        {
            return '超时重启的方式不对';
        }
        return $no_tip;
    }


}