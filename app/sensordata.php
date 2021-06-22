<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sensordata extends Model
{   
    public $table = "sensordata";

    protected $fillable = [
        'machine_id','lift_name','site_location','id', 'pv','batv','batvp','imei','temp','led_status', 'charging_status','updated_at'
    ];
}


