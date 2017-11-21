<?php


class Process
{

    /**
     * @param $keywords
     * @return array();
     * 根据关键字获取进程号
     */
    public static function get_pid_by_keywords($keywords)
    {
        $keywords || $keywords == __CLASS__;
        $shell = "ps -ef | grep -v 'grep' |grep -v 'bootstrap.sh' |grep -v 'sudo' | grep '{$keywords}'| awk '{print $2}'";
        $cmd_run = @popen($shell, 'r');
        $pid = array();
        while(!feof($cmd_run))
        {
            $content = trim(fgets($cmd_run, 1024));
            if (empty($content))
            {
                break;
            }
            $pid[] =$content;

        }
        @pclose($cmd_run);

        return $pid;
    }


    /**
     * @param $keywords
     * @return array();
     * 根据关键字获取进程号
     */
    public static function get_info_by_pid($pid)
    {
        if (empty($pid))
        {
            return array();
        }
        $shell = "ps -p {$pid} -o pid,cmd,stime,etime,uid,gid";
        $cmd_run = @popen($shell, 'r');
        $info = array();
        while(!feof($cmd_run))
        {
            $content = trim(fgets($cmd_run, 1024));
            if (empty($content))
            {
                break;
            }
            $info[] =$content;

        }
        @pclose($cmd_run);

        return $info;
    }



}
