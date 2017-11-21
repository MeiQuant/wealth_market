<?php


use Illuminate\Database\Capsule\Manager as DB;

class ConfigController extends AbstractController
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
    public function indexAction()
    {
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $ret = Models_Config::where('id', Util_Common::post('id'))->update(
                array(
                    'website' => Util_Common::post('website'),
                    'name' => Util_Common::post('name'),
                    'sms_alert_switch' => Util_Common::post('sms_alert_switch'),
                    'crash_sever_cron_switch' => Util_Common::post('crash_sever_cron_switch'),
                    'update_time' => date('Y-m-d H:i:s')
                )
            );
            if ($ret == 1)
            {
                _success_json_encoder('更新成功');
            }
            else
            {
                _error_json_encoder('更新失败');
            }
        }
        $config = Models_Config::first();
        $this->getView()->assign("title", "配置");
        $this->getView()->assign("config", $config);
        $this->getView()->display('config/index.html');
    }





}
