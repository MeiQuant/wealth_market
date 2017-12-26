<?php

use Illuminate\Database\Capsule\Manager as DB;

class PublishController extends Yaf_Controller_Abstract
{


   public function runAction()
   {
       // 早上6点定时发布文章
       $articles = DB::table('finance_article')->get();
       $update_article = [];
       $module_name = [];
       foreach ($articles as $article)
       {
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

       $ret_article = $this->updateBatch('finance_article', $update_article);
       if ($ret_article)
       {
           print_r('时间: ' . date('Y-m-d H:i:s') . ' ，发布成功的模块为 ' . implode(',' , $module_name));
           error_log('发布成功' . date('Y-m-d H:i:s') . PHP_EOL, 3, '/tmp/publish.log');
       }


       // 早上6点定时发布区域信息
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
