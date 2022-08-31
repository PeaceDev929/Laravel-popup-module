<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->position = 'Owner';
        $user->biography = '<p>Admin&nbsp;Biography</p>';
        $user->dateOfBirth = '2003-04-30';
        $user->password = bcrypt('password'); // password
        $user->save();
        $user->assignRole('admin');  
    }
}
