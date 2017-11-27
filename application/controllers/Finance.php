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
     * 主页区域部分内容添加
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
     * 主页文章部分内容添加
     */
    public function articleAction()
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
        $this->getView()->display('finance/article.html');
    }




}
