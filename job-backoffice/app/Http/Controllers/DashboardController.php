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
    if (auth()->user()->role == 'admin') {
            $analytics = $this->adminAnalytics();
          return view('dashboard.index', compact('analytics'));
        } else {
            $analytics = $this->companyOwnerAnalytics();
            return view('dashboard.index', compact('analytics'));

        }

        return view("dashboard.index", compact('analytics', 'mostAppliedJobs', 'conversationRates'));
    }
    private function adminAnalytics()
    {
        //last 30 days active users
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        //total jobs(not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        //total applications(not deleted)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();



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

             $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversationRates' => $conversationRates,
        ];
            return $analytics;
    }
    private function companyOwnerAnalytics()
    {
        $company = auth()->user()->company;

        //filter active users by applying to jobs of the company
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplication', function ($query) use ($company) {
                $query->whereIn('jobVacancyId', $company->jobVacancy->pluck('id'));
            })->count();

            //total jobs(not deleted) for the company
            $totalJobs = JobVacancy::where('companyId', $company->id)
                ->whereNull('deleted_at')
                ->count();

                //total applications(not deleted) for the company
                $totalApplications = JobApplication::whereHas('jobVacancy', function ($query) use ($company) {
                    $query->where('companyId', $company->id);
                })->whereNull('deleted_at')->count();

                //most applied jobs for the company
                $mostAppliedJobs = JobVacancy::where('companyId', $company->id)
                    ->withCount('jobApplication as totalCount')
                    ->orderBy('totalCount', 'desc')
                    ->take(5)
                    ->having('totalCount', '>', 0)
                    ->get();

                    //conversation rates for the company
                    $conversationRates = JobVacancy::where('companyId', $company->id)
                        ->withCount('jobApplication as totalCount')
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

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversationRates' => $conversationRates,
        ];

        return $analytics;
    }
}
