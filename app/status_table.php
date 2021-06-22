<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class status_table extends Model
{

    public $table = "status_table";

    protected $fillable = [
        'machine_id','lift_name','status'
    ];
}
