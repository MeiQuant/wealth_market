<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Daemon extends Models_Eloquent
{

    // 杀死进程
    public static function kill_process_by_keyword($keyword)
    {
        empty($keyword) && $keyword = __CLASS__;
        try
        {
            $pid = Process::get_pid_by_keywords($keyword);
            if (!empty($pid) && is_array($pid))
            {
                if (DEBUG)
                {
                    $kill_result = array();
                }
                foreach ($pid as $_pid)
                {
                    $ret = \Swoole\Process::kill($_pid, SIGKILL);
                    $kill_result[] = $ret;
                }
                // @todo, 通过接口杀死进程的时候, 如何释放进程信息呢
            }

            return true;
        }
        catch (\Exception $e)
        {
            if (DEBUG)
            {

            }
            return false;
        }

    }



}