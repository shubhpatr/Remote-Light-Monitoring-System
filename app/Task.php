<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'admin_id','machine_id','liftname','liftlocation','liftuid','lng','lat','led_status','created_at','updated_at'
    ];

    public function machine()
    {
        return $this->belongsTo('App\User','machine_id');
    }
}
