<?php


use Illuminate\Database\Capsule\Manager as DB;

class FinanceController extends AbstractController
{

    public $_valid = null;

    public $need_login = true;

    public function init()
    {
        $this->_valid = Validation::getInstance();
        parent::init();
    }

    public function testAction()
    {
        die(json_encode(array('sucess' => true, )));
        print_r($_FILES);
    }

    /**
     * 管理员添加或者更新主页文章
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $finance_id = Util_Common::get('finance_id');
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
                _success_json_encoder('添加成功');
            } catch (Exception $e) {
                _error_json_encoder('添加失败' . $e->getMessage());
            }

        }

        $this->getView()->assign(
            array(
                'title' => '今日财经文章',
                'finance_id' => $finance_id
            )
        );
        $this->getView()->display('finance/add.html');
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
