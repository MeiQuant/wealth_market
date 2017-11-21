<?php


use Illuminate\Database\Capsule\Manager as DB;

class CronController extends AbstractController
{

    public $_valid = null;

    public $need_login = true;

    public function init()
    {
        $this->_valid = Validation::getInstance();
        parent::init();
    }

    /**
     * cron列表
     */
    public function listAction()
    {
        $per_page = getConfig('page', 'cron_list');
        $count = Models_Crontab::count();
        $page = Util_Common::get('page', 1);
        $cron = Models_Crontab::with('server')->offset(($page - 1) * $per_page)->limit($per_page)->get();
        $this->getView()->assign('list', $cron->toArray());
        $paginate = new Util_Page($count, $per_page, $page);
        $this->getView()->assign('paginate', $paginate->myde_write());
        $this->getView()->assign("title", "cron列表");
        $this->getView()->display('cron/list.html');
    }

    /**
     * 添加cron
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $cron_id = Util_Common::get('cron_id');
        $cron_info = array();

        if ($request->isPost()) {
            $this->_valid->set_fields($_POST);
            $valid = $this->_valid->valid(
                'Models_Crontab',
                array(
                    'name' => 'is_valid_name',
                    'timer' => 'is_valid_timer',
                    'exec_file' => 'is_valid_exec_file',
                    'args' => 'is_valid_args',
                    'redirect' => 'is_valid_redirect',
                    'server_id' => 'is_valid_server',
                    'timeout_kill_type' => 'is_valid_timeout_kill_type'
                )
            );
            if (!$valid['status']) {
                _error_json_encoder($valid['msg']);
            }
            $datetime = date('Y-m-d H:i:s');
            try {
                $server_ids = explode(',', Util_Common::post('server_id'));
                $milli_time = Tool::get_milli_second();
                $hidden_update_id = Util_Common::post('hidden_update_id');
                if (!empty($hidden_update_id))
                {
                    $cron = Models_Crontab::where('id', $hidden_update_id)->first();
                    $keywords = explode(',', $cron->args);
                    $keywords = $keywords[0];
                    if (!Models_Daemon::kill_process_by_keyword($keywords))
                    {
                        Models_Daemon::kill_process_by_keyword($keywords);
                    }
                    $delete = Models_Crontab::where('id', $hidden_update_id)->delete();
                    if ($delete == false)
                    {
                        Models_Crontab::where('id', $hidden_update_id)->delete();
                    }
                }

                foreach ($server_ids as $server_id) {
                    $insert_data = array(
                        'name' => Util_Common::post('name'),
                        'timer' => Util_Common::post('timer'),
                        'exec_file' => Util_Common::post('exec_file'),
                        'args' => Util_Common::post('args'),
                        'redirect' => Util_Common::post('redirect'),
                        'timeout' => Util_Common::post('timeout'),
                        'server_id' => $server_id,
                        'timeout_kill_type' => Util_Common::post('timeout_kill_type'),
                        'repeat_num' => Util_Common::post('repeat_num'),
                        'exit_code' => 0,
                        'start_time' => $milli_time,
                        'finish_time' => $milli_time
                    );

                    $insert = Models_Crontab::create($insert_data);
                    if (empty($insert->id)) {
                        _error_json_encoder('添加失败' . $insert->id);
                    }
                }

                _success_json_encoder('添加成功');


            } catch (Exception $e) {
                _error_json_encoder('添加失败' . $e->getMessage());
            }

        }

        if (!empty($cron_id))
        {
            $cron_info = Models_Crontab::where('id', $cron_id)->first();
            $another_cron_info = Models_Crontab::where('name', $cron_info->name)->where('args', $cron_info->args)->where('id', '<>', $cron_info->id)->get(); // 某个cron在其他机器上也存在
            $another_cron_server_id = Tool::filter_by_field($another_cron_info, 'server_id');
            $servers = Models_Server::all();
            $server_ids = array_diff(Tool::filter_by_field($servers->toArray(), 'id'), array_merge(array($cron_info->server_id), $another_cron_server_id));
            $servers = Models_Server::whereIn('id', $server_ids)->get();
        }
        else
        {
            $servers = Models_Server::all();
        }

        $this->getView()->assign(array('title' => '添加cron', 'servers' => $servers, 'cron_id' => $cron_id, 'cron_info' => $cron_info));
        $this->getView()->display('cron/add.html');
    }


    /**
     * 删除cron
     */
    public function delAction()
    {
        $id = $page = Util_Common::post('id');
        if (empty($id)) {
            _error_json_encoder('请选择数据');
        }
        try {
            $id = explode(',', $id);

            foreach ($id as $cron_id)
            {
                $cron = Models_Crontab::where('id', $cron_id)->first();
                $keywords = explode(',', $cron->args);
                $kill_ret = true;
                if (!empty($keywords))
                {
                    $keywords = $keywords[0];
                    $kill_ret = Models_Daemon::kill_process_by_keyword($keywords);
                }
            }

            $del_ret = Models_Crontab::whereIn('id', $id)->delete();
            if ($del_ret == false)
            {
                Models_Crontab::whereIn('id', $id)->delete();
            }


            if ($del_ret !== false && $kill_ret == true) {
                _success_json_encoder('删除成功');
            }
            else
            {
                _error_json_encoder('删除或者杀死进程失败');
            }
        } catch (Exception $e) {
            _error_json_encoder($e->getMessage());
        }
    }



    /**
     * 更改cron状态, 使之成为可被执行的状态
     */
    public function restartAction()
    {
        $id = $page = Util_Common::post('id');
        if (empty($id)) {
            _error_json_encoder('请选择数据');
        }
        try {
            $id = explode(',', $id);
            $del_ret = Models_Crontab::whereIn('id', $id)->update(
                array(
                    'process_restart_type' => ''
                )
            );
            if ($del_ret !== false) {
                _success_json_encoder('手动重启成功');
            }
        } catch (Exception $e) {
            _error_json_encoder($e->getMessage());
        }
    }

}
