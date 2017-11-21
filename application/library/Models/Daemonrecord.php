<?php

use Illuminate\Database\Capsule\Manager as DB;

class Models_Daemonrecord extends Models_Eloquent
{

    protected $table = 'page_daemon_record';

    public $timestamps = false;

    protected $fillable = ['id', 'ip', 'create_time'];

}