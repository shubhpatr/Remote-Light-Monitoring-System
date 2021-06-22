<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'admin',
                'parent_id' => '1',
                'email' => 'admin@mushin.com',
                'password' =>bcrypt('admin123'),
                'userType' => 1,
            ],
    );
    }
}