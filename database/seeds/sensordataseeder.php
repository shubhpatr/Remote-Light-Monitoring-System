<?php

use Illuminate\Database\Seeder;

class sensordataseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\sensordata::class,20)->create();
    }
}
