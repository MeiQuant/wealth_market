<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Articleindex extends Models_Eloquent
{
    protected $table = 'finance_article';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['module', 'content', 'create_time'];

}