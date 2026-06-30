<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Jobcategory;
use App\Models\JobVacancy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        foreach ($jobData['jobVacancies'] as $vacancy) {
        $company = Company::where('name', $vacancy['company'])->firstOrFail();
        $category = Jobcategory::where('name', $vacancy['category'])->firstOrFail();




            JobVacancy::firstOrCreate([
            "title" => $vacancy["title"],
            "description"=> $vacancy["description"],
            "location"=> $vacancy["location"],
            "salary"=> $vacancy["salary"],
            "type"=> $vacancy["type"],
            "companyId"=> $company->id,
            "categoryId"=> $category->id,
            ]);
        }
    }
}
