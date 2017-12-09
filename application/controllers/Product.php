<?php

use Illuminate\Database\Capsule\Manager as DB;

class ProductController extends IndexabstractController
{

    public $_valid = null;

    public function init()
    {
        $this->_valid = Validation::getInstance();
        $this->_callback_request_uri = $_SERVER['REQUEST_URI'];
        parent::init();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $open_id = $this->_uid;
        $product = Models_Product::where('open_id', $open_id)->orderBy('id', 'desc')->first();
        if (!empty($product)) {
            $product = $product->toArray();
        } else {
            $product['company'] = $product['asset_strategy'] = $product['introduce'] = '';
        }
        if ($request->isPost()) {
            $this->_valid->set_fields($_POST);
            $valid = $this->_valid->valid(
                'Models_Product',
                array(
                    'company' => 'is_valid_company',
                    'asset_strategy' => 'is_valid_asset_strategy',
                    'introduce' => 'is_valid_introduce'
                )
            );

            if (!$valid['status']) {
                _error_json_encoder($valid['msg']);
            }
            $company = Util_Common::post('company');
            $asset_strategy = Util_Common::post('asset_strategy');
            $introduce = Util_Common::post('introduce');
            $datetime = date('Y-m-d H:i:s', time());
            $product = Models_Product::create(['open_id' => $open_id, 'company' => $company, 'asset_strategy' => $asset_strategy, 'introduce' => $introduce, 'create_time' => $datetime, 'update_time' => $datetime]);
            if (!empty($product->id)) {
                _success_json_encoder('保存成功');
            } else {
                _error_json_encoder('保存失败');
            }
        }
        $this->getView()->assign(['title' => '添加产品信息', 'product' => $product]);
        $this->getView()->display('product/index.html');
    }



}
