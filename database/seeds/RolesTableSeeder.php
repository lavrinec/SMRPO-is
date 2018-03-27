<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role_name' => 'Administrator',
            'description' => 'Administrator',
            'meta' => '',
            'created_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
            'role_name' => 'Product Owner',
            'description' => 'Product Owner',
            'meta' => '',
            'created_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
            'role_name' => 'Kanban Master',
            'description' => 'Kanban Master',
            'meta' => '',
            'created_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
            'role_name' => 'Razvijalec',
            'description' => 'Razvijalec',
            'meta' => '',
            'created_at' => Carbon::now()
        ]);
    }
}
