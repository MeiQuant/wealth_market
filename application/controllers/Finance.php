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
        $ret = DB::table('finance_article')->insert([
            ['module' => 1, 'content' => 2]
        ]);
        print_r($ret);die;
    }

    /**
     * 主页区域部分内容添加
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $page = DB::table('finance_page')->first();
        $page_id = '';
        if (!empty($page)) {
            $page['stock_market'] = json_decode($page['stock_market'], true);
            $page_id = $page['id'];
        }
        if ($request->isPost()) {
            try {
                $data = $_POST;
                $id = isset($data['hidden_page_id']) ? $data['hidden_page_id'] : '';

                $data['stock_market'] = json_encode($data['stock_market']);
                $insert_data = [
                    'audio' => trim($data['audio']),
                    'stock_market' => trim($data['stock_market']),
                    'company' => trim($data['company']),
                    'asset_strategy' => trim($data['strategy']),
                    'introduce' => trim($data['introduce']),
                    'qr_code' => trim($data['qr_code']),
                    'link' => trim($data['link']),
                ];
                if (empty($id)) {
                    $insert = Models_Page::create($insert_data);
                    $ret = $insert->id;
                } else {
                    $update = DB::table('finance_page')
                        ->where('id', $id)
                        ->update($insert_data);

                    $ret = $update;
                }
                if (!empty($ret)) {
                    _success_json_encoder('保存成功');
                } else {
                    throw new Exception('暂无更改信息');
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
            $module_article = DB::table('finance_article')->where('module', $module)->select('id')->first();
            $content_json = trim(Util_Common::post('content'));
            $content_json = $this->_handlefont($content_json);
            $content_array = json_decode($content_json, true);
            if (empty($content_array)) {
                _error_json_encoder('数据不合法');
            }
            try {
                // @todo, 数据校验
                if (empty($module_article)) {
                    $ret = DB::table('finance_article')->insert([
                        ['module' => $module, 'content' => $content_json]
                    ]);
                } else {
                    $ret = DB::table('finance_article')
                        ->where('module', $module)
                        ->update(['content' => $content_json]);
                }
                if ($ret !== false) {
                    _success_json_encoder('添加成功');
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

}
