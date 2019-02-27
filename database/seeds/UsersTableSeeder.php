<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->delete();

        $users = [
            ['name' => 'Stephan de Vries','email' => 'stephan-v@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'John doe', 'email' => 'johndoe@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'salma','email' => 'salma@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'manar', 'email' => 'manar@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'Ahmed','email' => 'Ahmed@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'Ali', 'email' => 'Ali@gmail.com', 'password' => Hash::make('secret')],
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
