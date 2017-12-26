<?php

use Illuminate\Database\Capsule\Manager as DB;

class IndexController extends IndexabstractController
{

    private $_format_introduct = '有多年金融行业经验，具有丰富的理财业务知识，熟知各项理财产品，能根据市场变化，和客户个人情况，为其提供个性化服务。';

    public function init()
    {
        $this->_callback_request_uri = isset($_SERVER['REQUEST_URI'])? $_SERVER['REQUEST_URI'] : '';
        parent::init();
    }

    public function indexAction()
    {
        $this->redirect('/admin/index');
    }



    public function showAction()
    {
        $request = $this->getRequest();
        $ouid = $this->filter_param('ouid');
        $page_id = Util_Common::get('page_id');
        $article_id = Util_Common::get('article_id');
        $open_id = $this->_uid;
        $is_share = false;
        // 区域部分信息
        if (!empty($page_id)) {
            $page_info = DB::table('finance_page')->where('id', $page_id)->orderBy('id', 'desc')->first();
        } else {
            $page_info = DB::table('finance_page')->orderBy('id', 'desc')->first();
        }
        if (!empty($page_info)) {
            $stock_market = json_decode($page_info['stock_market'], true);
            foreach ($stock_market as $stock) {
                $tmp_stock = explode('/', $stock);
                $tmp_stock[1] = explode('.', $tmp_stock[1]);
                $page_info['stock'][] = $tmp_stock;
            }
        }
        unset($page_info['stock_market']);



        if (!empty($ouid) && ($ouid != $open_id) && isset($_GET['from']) && strpos(trim($_GET['from']), 'message') !== false) {
            // 分享过来的链接
            $user_id = $ouid;
            $is_share = true;

        } else {
            $user_id  = $this->_uid;
        }


        // 个人信息
        $user = DB::table('finance_user')->where('open_id', $user_id)->first();
        $user['name'] = !empty($user['username']) ? $user['username'] : $user['nickname'];
        $user['introduce'] = !empty($user['introduce']) ? $user['introduce'] : $this->_format_introduct;


        // 如果该用户已经设置过产品信息, 优先展示用户自己的产品
        $user_product = DB::table('finance_product')->where('open_id', $user_id)->orderBy('id', 'desc')->first();

        $product['company'] = $page_info['company'];
        $product['asset_strategy'] = $page_info['asset_strategy'];
        $product['introduce'] = $page_info['introduce'];
        if (!empty($user_product)) {
            $product['company'] = !empty($user_product['company']) ? $user_product['company'] : $product['company'];
            $product['asset_strategy'] = !empty($user_product['asset_strategy']) ? $user_product['asset_strategy'] : $product['asset_strategy'];
            $product['introduce'] = !empty($user_product['introduce']) ? $user_product['introduce'] : $product['introduce'];
        }


        // 文章部分
        $publish_module  = DB::table('finance_article')->get();
        $module_id_name = [];
        foreach ($publish_module as $module)
        {
            $module_id_name[$module['id']] = $module['module'];
        }
        $mid = Tool::filter_by_field($publish_module, 'online_article_id');
        $wx_share_page_id = $page_info['id'];
        // 分享过来的
        if (!empty($article_id)) {
            $mid = explode(',', $article_id);
        }
        $wx_share_article_id = $mid;
        $articles = DB::table('finance_article_preview')->whereIn('id', $mid)->orderBy('module_id', 'asc')->get();


        if (!empty($articles)) {
            foreach ($articles as &$article) {
                $article['module'] =$module_id_name[$article['module_id']];
                $article['content'] = json_decode($article['content'], true);
            }
        }

        // 分享文案
        $wx_share = DB::table('finance_wechat')->first();

        $this->getView()->assign(['wx_share_page_id' => $wx_share_page_id, 'wx_share_article_id' => $wx_share_article_id, 'wx_share' => $wx_share, 'user' => $user, 'page_info' => $page_info, 'product' => $product,  'articles' => $articles, 'js_sdk' => $this->_app->js, 'ouid' => $user_id, 'is_share' => $is_share]);
        $this->getView()->display('index/show.html');
    }

}
