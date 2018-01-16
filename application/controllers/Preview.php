<?php

use Illuminate\Database\Capsule\Manager as DB;

class PreviewController extends Yaf_Controller_Abstract
{

    private $_format_introduct = '有多年金融行业经验，具有丰富的理财业务知识，熟知各项理财产品，能根据市场变化，和客户个人情况，为其提供个性化服务。';

    public function init()
    {

    }


    public function testAction()
    {
        $refer_url = '%2Findex%2Fshow%3Fpage_id%3D6%26article_id%3D1%2C2%2C3%2C4%2C5%2C6%26rdn%3D1515985236000%26ouid%3DoQt5h03B6WoEM7ri3sn7y7erFiyY%2523mp.weixin.qq.com%26from%3Dgroupmessage%26isappinstalled%3D0&code=021KvjtW0DvnnV10NupW0KajtW0KvjtH&state=a75eff8fc23fa7e223256e39bd7e1aaf';
//        var_dump(DOMAIN_URL . urldecode($refer_url));die;
        header('Location: '. DOMAIN_URL . urldecode($refer_url));
    }

    public function indexAction()
    {
        $this->redirect('/admin/index');
    }



    public function showAction()
    {
        $request = $this->getRequest();
        $ouid = 'oQt5h03tsXD7Wn6wWqzYDJ0umbEk';
        $type = Util_Common::get('type');
        $is_share = false;
        // 区域部分信息
        if (!empty($page_id)) {
            $page_info = DB::table('finance_page_preview')->where('id', $page_id)->first();
        } else {
            $online_page = DB::table('finance_page')->first();
            if (!empty($online_page))
            {
                $page_id = !empty($online_page['release_page_id']) ? $online_page['release_page_id'] : (!empty($online_page['online_page_id']) ? $online_page['online_page_id'] : '');
            }
            $page_info = DB::table('finance_page_preview')->where('id', $page_id)->first();
        }
        if (!empty($page_info))
        {
            $stock_market = json_decode($page_info['stock_market'], true);
            foreach ($stock_market as $stock) {
                $tmp_stock = explode('/', $stock);
                $tmp_stock[1] = explode('.', $tmp_stock[1]);
                $page_info['stock'][] = $tmp_stock;
            }
        }
        unset($page_info['stock_market']);


        // 分享过来的链接
        $user_id = $ouid;
        $is_share = true;

        // 个人信息
        $user = DB::table('finance_user')->where('open_id', $user_id)->first();
        $user['name'] = !empty($user['username']) ? $user['username'] : $user['nickname'];
        $user['introduce'] = !empty($user['introduce']) ? $user['introduce'] : $this->_format_introduct;


        $title = $is_share ? $user['name'] . '的财富早餐' : '有恒财富早餐';

        // 如果该用户已经设置过产品信息, 优先展示用户自己的产品
        $user_product = array();

        $product['company'] = $page_info['company'];
        $product['asset_strategy'] = $page_info['asset_strategy'];
        $product['introduce'] = $page_info['introduce'];
        if (!empty($user_product))
        {
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
        $release_article_id = Tool::filter_by_field($publish_module, 'release_article_id');
        if (!empty($release_article_id))
        {
            $mid = $release_article_id;
        }
        $wx_share_page_id = $page_id;
        // 分享过来的
        if (!empty($article_id))
        {
            $mid = explode(',', $article_id);
        }
        $wx_share_article_id = implode(',', $mid);
        $articles = DB::table('finance_article_preview')->whereIn('id', $mid)->orderBy('module_id', 'asc')->get();


        if (!empty($articles))
        {
            foreach ($articles as &$article)
            {
                $article['module'] =$module_id_name[$article['module_id']];
                $article['content'] = json_decode($article['content'], true);
            }
        }

        $types = [1 => [1], 2 => [2, 3, 4], 3 => [5, 6], 4 => []];


        $html_article = [];
        foreach ($articles as $_article)
        {
            if (in_array($_article['module_id'], $types[$type]))
            {
                $html_article[] = $_article;
            }
        }


        $is_share = false;
        $user = $this->_format_user_info($user);
        $this->getView()->assign(['wx_share_page_id' => $wx_share_page_id, 'type' => $type, 'wx_share_article_id' => $wx_share_article_id, 'user' => $user, 'page_info' => $page_info, 'product' => $product,  'articles' => $html_article, 'js_sdk' => '', 'ouid' => $user_id, 'is_share' => $is_share, 'title' => $title, 'type' => $type]);
        $this->getView()->display('index/preview.html');
    }



    private function _format_user_info($user)
    {
        $city = ['北京', '天津', '上海', '重庆', '北京市', '天津市', '上海市', '重庆市'];
        if (in_array($user['province'], $city))
        {
            if (strpos($user['province'], '市') !== false)
            {
                $user['province'] = mb_substr($user['province'], 0, mb_strpos($user['province'], '市'), 'utf-8');
            }
            if (strpos($user['city'], '区') === false)
            {
                $user['city'] = $user['city'] . '区';
            }
        }
        else
        {
            if (strpos($user['province'], '省') !== false)
            {
                $user['province'] = mb_substr($user['province'], 0, mb_strpos($user['province'], '省'), 'utf-8');
            }

            if (strpos($user['city'], '市') === false)
            {
                $user['city'] = $user['city'] . '市';
            }
        }

        return $user;
    }

}
