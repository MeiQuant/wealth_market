<?php

use Illuminate\Database\Capsule\Manager as DB;

class PublishController extends Yaf_Controller_Abstract
{
    public function testAction()
    {
        echo date('Y-m-d H:i:s', time()) . PHP_EOL;
    }

   public function runAction()
   {
       // 早上6点定时发布文章
       $articles = DB::table('finance_article')->get();
       $update_article = [];
       $module_name = [];
       foreach ($articles as $article)
       {
           if (empty($article['release_article_id']))
           {
               continue;
           }
           if (!empty($article['release_article_id']))
           {
               $module_name[] = $article['module'];
           }
           $update_article[] = [
               'id' => $article['id'],
               'online_article_id' => $article['release_article_id'],
               'release_article_id' => ''
           ];
       }

       if (!empty($update_article))
       {
           $ret_article = $this->updateBatch('finance_article', $update_article);
           if ($ret_article)
           {
               print_r('时间: ' . date('Y-m-d H:i:s') . ' ，发布成功的文章模块为 ' . implode(',' , $module_name) . PHP_EOL);
               error_log('时间: ' . date('Y-m-d H:i:s') . ' ，发布成功文章的模块为 ' . implode(',' , $module_name) . PHP_EOL, 3, '/tmp/publish.log');
           }
       }
       else
       {
           print_r('时间: ' . date('Y-m-d H:i:s') . ' ，暂时没有要发布的文章模块' . PHP_EOL);
           error_log('时间: ' . date('Y-m-d H:i:s') . ' ，暂时没有要发布的文章模块'  . PHP_EOL, 3, '/tmp/publish.log');
       }


       $publish_page = DB::table('finance_page')->first();
       if (!empty($publish_page) && isset($publish_page['release_page_id']) && !empty($publish_page['release_page_id']))
       {
           // 早上6点定时发布区域信息
           $ret_page = DB::table('finance_page')->orderBy('id', 'desc')->limit(1)->update(['online_page_id' => DB::raw('release_page_id'), 'release_page_id' => '']);
           if (!empty($ret_page))
           {
               print_r('时间: ' . date('Y-m-d H:i:s') . '各区域模块发布成功'. PHP_EOL);
               error_log('时间: ' . date('Y-m-d H:i:s') . '各区域模块发布成功'. PHP_EOL, 3, '/tmp/publish.log');
           }
       }
       else
       {
           print_r('时间: ' . date('Y-m-d H:i:s') . '没有要发布的区域模块'. PHP_EOL);
           error_log('时间: ' . date('Y-m-d H:i:s') . '没有要发布的区域模块'. PHP_EOL, 3, '/tmp/publish.log');
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
