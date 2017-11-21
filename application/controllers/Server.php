<?php


use Illuminate\Database\Capsule\Manager as DB;

class ServerController extends AbstractController
{

    public $_valid = null;

    public $need_login = true;

    public function init()
    {
        $this->_valid = Validation::getInstance();
        parent::init();
    }

    /**
     * server列表
     */
    public function listAction()
    {
        $per_page = getConfig('page', 'server_list');
        $count = Models_Server::count();
        $page = Util_Common::get('page', 1);
        $cron = Models_Server::offset(($page - 1) * $per_page)->limit($per_page)->get();
        $this->getView()->assign('list', $cron->toArray());
        $paginate = new Util_Page($count, $per_page, $page);
        $this->getView()->assign('paginate', $paginate->myde_write());
        $this->getView()->assign("title", "server列表");
        $this->getView()->display('server/list.html');
    }

    /**
     * 添加server
     */
    public function addAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->_valid->set_fields($_POST);
            $valid = $this->_valid->valid('Models_Server', array('name' => 'is_valid_name', 'ip' => 'is_valid_ip'));
            if (!$valid['status']) {
                _error_json_encoder($valid['msg']);
            }
            $datetime = date('Y-m-d H:i:s');
            try {
                $insert = Models_Server::create(array(
                    'server_name' => trim($_POST['name']),
                    'ip' => trim($_POST['ip']),
                    'status' => 0,
                    'create_time' => $datetime,
                    'update_time' => $datetime
                ));
            } catch (Exception $e) {
                _error_json_encoder('添加失败' . $e->getMessage());
            }
            if (!empty($insert->id)) {
                _success_json_encoder('添加成功, id为' . $insert->id);
            }
        }

        $this->getView()->assign("title", "添加server");
        $this->getView()->display('server/add.html');
    }


    /**
     * 删除server
     */
    public function delAction()
    {
        $id = $page = Util_Common::post('id');
        if (empty($id)) {
            _error_json_encoder('请选择数据');
        }
        try {
            $id = explode(',', $id);
            $del_ret = Models_Server::whereIn('id', $id)->delete();
            if ($del_ret !== false) {
                _success_json_encoder('删除成功');
            }
        } catch (Exception $e) {
            _error_json_encoder($e->getMessage());
        }
    }



}
