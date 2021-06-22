<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\sensordata;

class testcontroller extends Controller
{
    public function index()
    {
        $data = sensordata::get();
        return $data;
    }
}
