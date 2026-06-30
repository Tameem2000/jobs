<?php

namespace Database\Seeders;

use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplication = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        foreach($jobApplication['jobApplications'] as $application){

        $jobVacancy = JobVacancy::inRandomOrder()->first();


            $app = User::firstOrCreate([
            'email'=> fake()->unique()->safeEmail(),
            'name'=> fake()->name(),
            'password'=> Hash::make('12345678'),
            'role'=>'job-seeker',
            'email_verified_at'=>now(),
                ]);

        $resume = Resume::create([
        'userId'=> $app->id,
        'fileName'=>$application['resume']['filename'],
        'fileUrl'=>$application['resume']['fileUri'],
        'contactDetailes'=>$application['resume']['contactDetails'],
        'summary'=>$application['resume']['summary'],
        'skills'=>$application['resume']['skills'],
        'experience'=>$application['resume']['experience'],
        'education'=>$application['resume']['education'],
        ]);
    JobApplication::create([
        'jobVacancyId'=> $jobVacancy->id,
        'userId'=> $app->id,
        'resumeId'=> $resume->id,
        'status'=> $application['status'],
        'aiGeneratedScore'=> $application['aiGeneratedScore'],
        'aiGeneratedFeedback'=> $application['aiGeneratedFeedback'],
    ]);
    }
  }
}
