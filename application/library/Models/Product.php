<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Product extends Models_Eloquent
{
    protected $table = 'finance_product';



    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['open_id', 'company', 'asset_strategy', 'introduce', 'create_time', 'update_time'];


    public static function is_valid_company($company) {
        $no_tip = '';
        if (empty($company)) {
            return '公司名称不能为空';
        }
        return $no_tip;
    }


    public static function is_valid_asset_strategy($asset_strategy) {
        $no_tip = '';
        if (empty($asset_strategy)) {
           return '资产配置策略不能为空';
        }
        return $no_tip;
    }

    public static function is_valid_introduce($introduce) {
        $no_tip = '';
        if (empty($introduce)) {
            return '推荐理由不能为空';
        }
        return $no_tip;
    }




}