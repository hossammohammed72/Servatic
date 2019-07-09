<?php

use Illuminate\Database\Seeder;
use App\User;
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

        for($i=0; $i<10; $i++){
            $user = User::create([
                'name'=> str_random(4),
                'email'=> str_random(4).'@mail.com',
                'password'=> bcrypt('secret')
            ]);
            //agent::create(['user_id'=>$user->id, 'company_id'=>Company::inRandomOrder()->first()->id]);
            $agent = new Agent();
            $agent->user_id = $user->id;
            $agent->company_id = Company::inRandomOrder()->first()->id;
            $agent->save();
        }
    }
}
