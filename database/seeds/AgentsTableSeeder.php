<?php

use Illuminate\Database\Seeder;
use App\user;
use App\Models\Agent;
use App\Models\Company;

class AgentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agents')->delete();

        for($i=0; $i<10; $i++){
            $user = user::create([
                'name'=> str_random(4),
                'email'=> str_random(4).'@mail.com',
                'password'=> bcrypt('secret')
            ]);
            agent::create(['user_id'=>$user->id, 'company_id'=>Company::inRandomOrder()->first()->id]);
        }
    }
}
