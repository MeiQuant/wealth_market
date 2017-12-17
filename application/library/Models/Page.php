<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Page extends Models_Eloquent
{
    protected $table = 'finance_page';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['audio', 'stock_market', 'company', 'asset_strategy', 'introduce', 'qr_code', 'link', 'is_publish'];

}