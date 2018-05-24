<?php

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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'usertype' => '0',
            'password' => bcrypt('admin@123'),
            'xpass' => 'admin@123',
        ]);
        
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@user.com',
            'usertype' => '1',
            'password' => bcrypt('admin@123'),
            'xpass' => 'admin@123'
        ]);
    }
}
