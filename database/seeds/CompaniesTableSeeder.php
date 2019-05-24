<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();

        $companies =[
            ['name' => 'Vodafone'],
            ['name' => 'Etisalat'],
            ['name' => 'orange']
        ];
        foreach($companies as $company){
            Company::create($company);
        }
    }
}
