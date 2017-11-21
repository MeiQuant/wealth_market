<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Config extends Models_Eloquent
{
    protected $table = 'page_config';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['website', 'name', 'sms_alert_switch', 'create_time', 'update_time'];


}