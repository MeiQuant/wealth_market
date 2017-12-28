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

    }
    public function indexAction()
    {
        $modules = Models_Articleindex::all();

        $modules = $modules->toArray();

        $is_fixed_publish = false; // 今天是否定时发布过
        foreach ($modules as &$module)
        {
            $module_id = $module['id'];
            $last_article = DB::table('finance_article_preview')->where('module_id', $module_id)->orderBy('id', 'desc')->first();
            $module['last_article_id'] = !empty($last_article) ? $last_article['id'] : '';
        }

        foreach ($modules as $ori_module)
        {
            if (!empty($ori_module['release_article_id']))
            {
                $is_fixed_publish = true;
                break;
            }
        }
        $this->getView()->assign(
            array(
                'title' => '模块列表',
                'list' => $modules
            )
        );
        $this->getView()->assign(
            array(
                'is_fixed_publish' => $is_fixed_publish,

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
        $page = DB::table('finance_page_preview')->orderBy('id', 'desc')->first();
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
                if (!in_array($flag, array('add', 'update', 'publish')))
                {
                    _error_json_encoder('操作不合法');
                }

                $data['stock_market'] = json_encode($data['stock_market']);
                $insert_data = [
                    'audio' => trim($data['audio']),
                    'stock_market' => trim($data['stock_market']),
                    'company' => trim($data['company']),
                    'asset_strategy' => trim($data['strategy']),
                    'introduce' => trim($data['introduce']),
                    'qr_code' => trim($data['qr_code']),
                    'link' => trim($data['link']),
                    'wechat_title' => trim($data['wechat_title']),
                    'wechat_desc' => trim($data['wechat_desc']),

                ];

                $message = '';
                if ($flag == 'update')
                {
                    if (empty($id))
                    {
                        _error_json_encoder('操作不合法');
                    }

                    $ret = DB::table('finance_page_preview')->where('id', $id)->update($insert_data);
                    $message = '更新成功';

                }
                elseif ($flag == 'add')
                {
                    $ret = DB::table('finance_page_preview')->insert($insert_data);
                    $message = '添加成功';
                }
                elseif ($flag == 'publish')
                {
                    // 定时发布, 把最后一篇文章定时发布
                    $last_page = DB::table('finance_page_preview')->orderBy('id', 'desc')->first();
                    if (empty($last_page))
                    {
                        _error_json_encoder('暂时没有定时发布的page页');
                    }

                    $page_id = $last_page['id'];
                    $ret = DB::table('finance_page')->orderBy('id', 'desc')->limit(1)->update(['release_page_id' => $page_id]);
                    $message = '定时发布成功';
                }

                if (!empty($ret))
                {
                    _success_json_encoder($message);
                }
                else
                {
                    _error_json_encoder('操作失败');
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
        $module_id = Util_Common::get('module_id');
        $article_id = Util_Common::get('article_id');
        $module = DB::table('finance_article')->where('id', $module_id)->first();
        $article = [];
        if (!empty($article_id))
        {
            $article = DB::table('finance_article_preview')->where('id', $article_id)->first();
            $article['content'] = json_decode($article['content'], true);
        }
        $article['module'] = $module['module'];
        if ($request->isPost()) {
            $module_id = trim(Util_Common::post('module_id'));
            $article_id = trim(Util_Common::post('article_id'));
            $flag = trim(Util_Common::post('flag'));
            $content_json = trim(Util_Common::post('content'));

            if (!in_array($flag, ['add', 'update']))
            {
                _error_json_encoder('操作不合法');
            }
            $content_json = $this->_handlefont($content_json);
            $content_array = json_decode($content_json, true);
            if (empty($content_array)) {
                _error_json_encoder('数据不合法');
            }
            try {
                $ret = true;
                $message = '';
                if ($flag == 'update')
                {
                    if (empty($article_id))
                    {
                        _error_json_encoder('应点击存储按钮，而不是更新按钮');
                    }
                    $ret = DB::table('finance_article_preview')->where('id', $article_id)->update(['module_id' => $module_id, 'content' => $content_json, 'update_time' => date('Y-m-d H:i:s')]);
                    $message = '更新成功';
                }
                elseif ($flag == 'add')
                {
                    $ret = DB::table('finance_article_preview')->insert([
                        ['module_id' => $module_id, 'content' => $content_json, 'update_time' => date('Y-m-d H:i:s'), 'create_time' => date('Y-m-d H:i:s')]
                    ]);
                    $message = '存储成功';
                }

                if ($ret !== false) {
                    _success_json_encoder($message);
                }
                else
                {
                    _error_json_encoder('操作失败, 请联系管理员');
                }
            } catch (\Exception $e) {
                _error_json_encoder('添加失败' . $e->getMessage());
            }
        }


        $this->getView()->assign(
            array(
                'title' => '今日财经文章',
                'article' => $article,
                'module_id' => $module_id,
                'article_id' => $article_id
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


    // 定时发布
    public function publishAction()
    {

        $mid = DB::table('finance_article_preview')->select(DB::raw('max(id) as mid'))->groupBy('module_id')->get();
        if (!empty($mid))
        {
            $mid = Tool::filter_by_field($mid, 'mid');
        }

        $articles = DB::table('finance_article_preview')->whereIn('id', $mid)->get();
        if (empty($articles))
        {
            _error_json_encoder('暂时没有需要发布的文章');
        }

        $update_data = [];
        foreach ($articles as $article)
        {
            $update_data[] = [
                'id' => $article['module_id'],
                'release_article_id' => $article['id']
            ];
        }

        try
        {
            $ret = $this->updateBatch('finance_article', $update_data);
        }
        catch (\Exception $e)
        {
            _error_json_encoder($e->getMessage());
        }
        if ($ret !== false)
        {
            _success_json_encoder('定时发布成功');
        }
        else
        {
            _success_json_encoder('定时发布失败, 有可能发布的文章id没有变化');
        }


    }



    public function updateBatch($tableName = "", $multipleData = array()){

        if($tableName && !empty($multipleData))
        {
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";
            $q = "UPDATE ".$tableName." SET ";
            foreach ( $updateColumn as $uColumn ) {
                $q .=  $uColumn." = CASE ";

                foreach( $multipleData as $data ) {
                    $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";
                }
                $q .= "ELSE ".$uColumn." END, ";
            }
            foreach( $multipleData as $data ) {
                $whereIn .= "'".$data[$referenceColumn]."', ";
            }
            $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";

            // Update
            return DB::update(DB::raw($q));

        }
        else
        {
            return false;
        }

    }


}
