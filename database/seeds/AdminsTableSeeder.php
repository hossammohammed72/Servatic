<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            ['name' => 'Stephan de Vries','email' => 'stephan-v@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'John doe', 'email' => 'johndoe@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'salma','email' => 'salma@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'manar', 'email' => 'manar@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'Ahmed','email' => 'Ahmed@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'Ali', 'email' => 'Ali@gmail.com', 'password' => Hash::make('secret')],
        ];

        foreach($users as $user){
            $user = User::create($user);
            Admin::create(['user_id'=>$user->id]);
        }
    }
}
