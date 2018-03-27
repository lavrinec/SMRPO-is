<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.si',
            'password' => bcrypt('admin1234'),
            'created_at' => Carbon::now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'testni',
            'last_name' => 'testni',
            'email' => 'testni@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()
        ]);
    }
}
