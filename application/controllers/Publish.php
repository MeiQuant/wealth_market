<?php

use Illuminate\Database\Capsule\Manager as DB;

class PublishController extends Yaf_Controller_Abstract
{


   public function runAction()
   {
       $articles = DB::table('finance_article')->where('is_publish', 1)->orderBy('id', 'desc')->get();
       // 数量不会很多
       if (!empty($articles)) {
          $ids = Tool::filter_by_field($articles, 'id');
          $ret = DB::table('finance_article')->whereIn('id', $ids)->update(['is_publish' => 2, 'update_time' => date('Y-m-d H:i:s')]);
           error_log('id : ' . json_encode($ids) . ' time : ' . date('Y-m-d H:i:s') , 3, '/tmp/publish.log');
       }
   }

}
