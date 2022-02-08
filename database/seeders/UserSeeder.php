<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            ['name' => 'Cedric', 'email' => 'cedric@gmail.com', 'password' => bcrypt('123456'), 'role_id' => 2],
            ['name' => 'Axel', 'email' => 'axel@gmail.com', 'password' => bcrypt('123456'), 'role_id' => 1],
        ]);
    }
}
