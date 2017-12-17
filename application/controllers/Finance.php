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

    public function indexAction()
    {
        $data = Models_Articleindex::all();
        if (!empty($data)) {
            $data = $data->toArray();
            foreach ($data as &$article) {
                $article['content'] = json_decode($article['content']);
                $article['article_count']= count($article['content']);
                unset($article['content']);
            }
        }

        $this->getView()->assign(
            array(
                'title' => '模块列表',
                'list' => $data
            )
        );
        $this->getView()->display('finance/index.html');
    }

    /**
     * 主页区域部分内容添加
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $page = DB::table('finance_page')->orderBy('id', 'desc')->first();
        $page_id = '';
        if (!empty($page)) {
            $page['stock_market'] = json_decode($page['stock_market'], true);
            $page_id = $page['id'];
        }
        if ($request->isPost()) {
            try {
                $data = $_POST;
                $id = isset($data['hidden_page_id']) ? $data['hidden_page_id'] : '';
                $flag = trim($data['flag']);
                $data['stock_market'] = json_encode($data['stock_market']);
                $insert_data = [
                    'audio' => trim($data['audio']),
                    'stock_market' => trim($data['stock_market']),
                    'company' => trim($data['company']),
                    'asset_strategy' => trim($data['strategy']),
                    'introduce' => trim($data['introduce']),
                    'qr_code' => trim($data['qr_code']),
                    'link' => trim($data['link']),
                    'is_publish' => strpos($flag, 'publish') !== false ? 1 : 0
                ];


                if (strpos($flag, 'add') !== false) {
                    $type = 'add';
                } elseif (strpos($flag, 'update') !== false) {
                    $type = 'update';
                } elseif (empty($id)) {
                    $type = 'add';
                } else {
                    $type = 'add';
                }

                if ($type == 'add') {
                    $insert = Models_Page::create($insert_data);
                    $ret = $insert->id;
                } else {
                    $update = DB::table('finance_page')
                        ->where('id', $id)
                        ->update($insert_data);

                    $ret = $update;
                }

                $msg = array(
                    'update_preview' => '修改内容预览成功,等待发布',
                    'update_publish' => '修改内容发布成功',
                    'add_preview' => '新增内容预览成功, 等待发布',
                    'add_publish' => '新增内容发布成功'
                 );
                if (!empty($ret)) {
                    _success_json_encoder($msg[$flag]);
                } else {
                    throw new Exception('系统错误, 请联系管理员');
                }
            } catch (Exception $e) {
                _error_json_encoder($e->getMessage());
            }

        }

        $this->getView()->assign(
            array(
                'title' => '今日财经文章',
                'page_id' => $page_id,
                'page' => $page
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
        $module_id = Util_Common::get('id');
        $article = DB::table('finance_article')->where('id', $module_id)->first();
        if (!empty($article)) {
            $article['content'] = json_decode($article['content'], true);
        }
        if ($request->isPost()) {
            $module = trim(Util_Common::post('module_name'));
            $module_id = trim(Util_Common::post('module_id'));
            $flag = trim(Util_Common::post('flag'));
            $content_json = trim(Util_Common::post('content'));
            if (strpos($flag, 'add') !== false) {
                $type = 'add';
            } elseif (strpos($flag, 'update') !== false) {
                $type = 'update';
            } else {
                $type = 'add';
            }
            $content_json = $this->_handlefont($content_json);
            $content_array = json_decode($content_json, true);
            if (empty($content_array)) {
                _error_json_encoder('数据不合法');
            }
            try {
                // @todo, 数据校验
                if ($type == 'add') {
                    $ret = DB::table('finance_article')->insert([
                        ['module' => $module, 'content' => $content_json, 'update_time' => date('Y-m-d H:i:s'), 'is_publish' => strpos($flag, 'publish') !== false ? 1 : 0]
                    ]);
                } elseif ($type == 'update') {
                    // 将之前的模块都下线
                    $ret = DB::table('finance_article')
                        ->where('id', $module_id)
                        ->update(['content' => $content_json, 'update_time' => date('Y-m-d H:i:s'), 'is_publish' => strpos($flag, 'publish') !== false ? 1 : 0]);
                } else {
                    $ret = DB::table('finance_article')->insert([
                        ['module' => $module, 'content' => $content_json, 'update_time' => date('Y-m-d H:i:s'), 'is_publish' => strpos($flag, 'publish') !== false ? 1 : 0]
                    ]);
                }
                if ($ret !== false) {
                    _success_json_encoder('保存成功');
                }
            } catch (\Exception $e) {
                _error_json_encoder('添加失败' . $e->getMessage());
            }
        }


        $this->getView()->assign(
            array(
                'title' => '今日财经文章',
                'article' => $article,
                'module_id' => $module_id
            )
        );
        $this->getView()->display('finance/article.html');
    }



    public function delmoduleAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = trim(Util_Common::post('id'));
            if (empty($id)) {
                _error_json_encoder('参数错误');
            }

            $del_ret = Models_Articleindex::where('id', $id)->delete();
            if ($del_ret != false)
            {
                _success_json_encoder('删除成功');
            }
        }
    }

    private function _handlefont($str)
    {
        $pattern = '/<font color=\"#(.*?)\">(.*?)<\/font>/';
        preg_match_all($pattern, $str, $matches);
        if (isset($matches[0]) && !empty($matches[0])) {
            foreach ($matches[0] as $sort => $font_str) {
                $replace = "<font color='#{$matches[1][$sort]}'>{$matches[2][$sort]}</font>";
                $str = str_replace($font_str, $replace, $str);
            }
        }
        return $str;
    }


    /**
     * 微信的一些相关设置
     */
    public function wechatAction()
    {
        $request = $this->getRequest();
        $wechat = DB::table('finance_wechat')->first();
        if ($request->isPost()) {
            $title = trim(Util_Common::post('title'));
            $description = trim(Util_Common::post('desc'));
            try {
                $datetime = date('Y-m-d H:i:s', time());
                // @todo, 数据校验
                if (empty($wechat)) {
                    $ret = DB::table('finance_wechat')->insert([
                        ['title' => $title, 'description' => $description, 'update_time' => $datetime, 'create_time' => $datetime]
                    ]);
                } else {
                    $ret = DB::table('finance_wechat')
                        ->where('id', $wechat['id'])
                        ->update(['title' => $title, 'description' => $description, 'update_time' => $datetime]);
                }
                if ($ret !== false) {
                    _success_json_encoder('保存成功');
                }
            } catch (\Exception $e) {
                _error_json_encoder('保存失败' . $e->getMessage());
            }
        }

        $this->getView()->assign(
            array(
                'title' => '微信分享设置',
                'wechat' => $wechat
            )
        );
        $this->getView()->display('finance/wechat.html');

    }

}
