<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.si',
            'password' => bcrypt('admin1234'),
            'created_at' => Carbon::now()
        ])->usersRoles()->create(['role_id' => 1]);
        User::create([
            'first_name' => 'Kanban',
            'last_name' => 'Master',
            'email' => 'km@admin.si',
            'password' => bcrypt('admin1234'),
            'created_at' => Carbon::now()
        ])->usersRoles()->create(['role_id' => 3]);
        User::create([
            'first_name' => 'Product',
            'last_name' => 'Owner',
            'email' => 'po@admin.si',
            'password' => bcrypt('admin1234'),
            'created_at' => Carbon::now()
        ])->usersRoles()->create(['role_id' => 2]);
        User::create([
            'first_name' => 'Razvojni',
            'last_name' => 'Razvijalec',
            'email' => 'r@admin.si',
            'password' => bcrypt('admin1234'),
            'created_at' => Carbon::now()
        ])->usersRoles()->create(['role_id' => 4]);
        $u = User::create([
            'first_name' => 'Čisto',
            'last_name' => 'Vse',
            'email' => 'vse@admin.si',
            'password' => bcrypt('admin1234'),
            'created_at' => Carbon::now()
        ])->usersRoles();
        $u->create(['role_id' => 1]);
        $u->create(['role_id' => 2]);
        $u->create(['role_id' => 3]);
        $u->create(['role_id' => 4]);
        User::create([
            'first_name' => 'Čisto',
            'last_name' => 'Nič',
            'email' => 'nic@admin.si',
            'password' => bcrypt('admin1234'),
            'created_at' => Carbon::now()
        ]);
        User::create([
            'first_name' => 'testni',
            'last_name' => 'testni',
            'email' => 'testni@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()
        ]);
    }
}
