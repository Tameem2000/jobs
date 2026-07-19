<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function index()
    {
        $jobs = JobApplication::where('userId', auth()->id())->latest()->paginate(10);

        return view('job-applications.index', compact('jobs'));
    }

    public function show($id)
    {
        $jobApplication = JobApplication::findOrFail($id);

        return view('job-applications.show', compact('jobApplication'));
    }
}
