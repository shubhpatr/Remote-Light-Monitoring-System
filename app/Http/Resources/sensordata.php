<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class sensordata extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [ 
            'machine_id' => $this ->machine_id,
            'lift_name' => $this ->lift_name,
            'site_location' => $this ->site_location,
            'pv' => $this ->pv,
            'batv' => $this ->batv,
            'batvp' => $this ->batvp,
            'imei' => $this ->imei,
            'temp' => $this ->temp,
            'led_status' => $this ->led_status,
            'charging_status' => $this ->charging_status,
            'updated_at' => $this ->updated_at,
           
        ];
    }
}
