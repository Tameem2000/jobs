<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        foreach ($jobData['companies'] as $company) {

        $companyOwner = User::firstOrCreate([
            'email'=> fake()->unique()->safeEmail(),
            'name'=> fake()->name(),
            'password'=> Hash::make('12345678'),
            'role'=>'company-owner',
            'email_verified_at'=>now(),
            ]);
         Company::firstOrCreate([
            "name" => $company["name"],
            "address"=> $company["address"],
            "industry"=> $company["industry"],
            "website"=> $company["website"],
            "ownerId"=> $companyOwner->id,
            ]);
        }
    }
}
