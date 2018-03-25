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
            'first_name' => 'testni',
            'last_name' => 'testni',
            'email' => 'testni@gmail.com',
            'password' => bcrypt('testni'),
            'created_at' => Carbon::now()
        ]);
    }
}
