<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jobcategory;


class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name'=> $category,
            ]);
        }

    }
}
