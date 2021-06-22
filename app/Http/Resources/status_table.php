<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class status_table extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [ 
            
            'lift_name' => $this ->lift_name,
            'status' => $this ->status,
            'updated_at' => $this ->updated_at,
           
        ];
    }
}
