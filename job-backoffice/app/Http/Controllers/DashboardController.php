<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use \App\Models\User;
use \App\Models\JobVacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //last 30 days active users
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        //total jobs(not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        //total applications(not deleted)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
        ];

        $mostAppliedJobs = JobVacancy::withCount('jobApplication as totalCount')
            ->orderBy('totalCount', 'desc')
            ->take(5)
            ->having('totalCount', '>', 0)
            ->get();

        $conversationRates = JobVacancy::withCount('jobApplication as totalCount')
            ->orderBy('totalCount', 'desc')
            ->take(5)
            ->get()
            ->map(function ($resault) {
                if ($resault->viewCount > 0) {
                    $resault->conversationRate = round($resault->totalCount / $resault->viewCount * 100, 2);
                } else {
                    $resault->conversationRate = 0;
                }
                return $resault;
            });

        return view("dashboard.index", compact('analytics', 'mostAppliedJobs', 'conversationRates'));
    }
}
