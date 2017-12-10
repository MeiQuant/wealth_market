<?php

use Illuminate\Database\Capsule\Manager as DB;

class IndexController extends IndexabstractController
{

    private $_format_introduct = '有多年金融行业经验，具有丰富的理财业务知识，熟知各项理财产品，能根据市场变化，和客户个人情况，为其提供个性化服务。';

    public function init()
    {
        $this->_callback_request_uri = $_SERVER['REQUEST_URI'];
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
        $open_id = $this->_uid;
        $is_share = false;
        // 区域部分信息
        $page_info = DB::table('finance_page')->orderBy('id', 'desc')->first();
        if (!empty($page_info)) {
            $stock_market = json_decode($page_info['stock_market'], true);
            foreach ($stock_market as $stock) {
                $tmp_stock = explode('/', $stock);
                $tmp_stock[1] = explode('.', $tmp_stock[1]);
                $page_info['stock'][] = $tmp_stock;
            }
        }
        unset($page_info['stock_market']);




        if (!empty($ouid) && ($ouid != $open_id) && isset($_GET['from']) && trim($_GET['from'] == WX_SHARE)) {
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
        $product = DB::table('finance_product')->where('open_id', $user_id)->orderBy('id', 'desc')->first();

        if (!empty($user_product)) {
            $product['company'] = isset($page_info['company']) ? $page_info['company'] : '';
            $product['asset_strategy'] = isset($page_info['company']) ? $page_info['asset_strategy'] : '';
            $product['introduce'] = isset($page_info['introduce']) ? $page_info['introduce'] : '';
        }


        // 文章部分
        $articles  = DB::table('finance_article')->get();
        if (!empty($articles)) {
            foreach ($articles as &$article) {
                $article['content'] = json_decode($article['content'], true);
            }
        }
        $this->getView()->assign(['user' => $user, 'page_info' => $page_info, 'product' => $product,  'articles' => $articles, 'js_sdk' => $this->_app->js, 'ouid' => $user_id, 'is_share' => $is_share]);
        $this->getView()->display('index/show.html');
    }

}
