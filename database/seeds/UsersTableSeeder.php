<?php

use Illuminate\Database\Seeder;

use App\User;

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
            'username' => 'superadmin',
            'name' => 'Super Admin',
            'role' => 'super_admin',
            'password' => bcrypt('123456'),
        ]);

        
        User::create([
            'username' => 'admin1',
            'name' => 'Admin1',
            'role' => 'admin',
            'password' => bcrypt('123456'),
        ]);
    }
}
