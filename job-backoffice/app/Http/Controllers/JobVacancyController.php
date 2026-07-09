<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\Jobcategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::latest();

        if (auth()->user()->role == "company-owner") {
            $query->where('companyId', auth()->user()->company->id);
        }

        if ($request->input('archive') == true) {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(10)->onEachSide(1);

        return view('job-vacancy.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $categories = Jobcategory::all();

        return view('job-vacancy.create', compact('companies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validate = $request->validated();
        JobVacancy::create($validate);

        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the vacancy by ID, or throw a 404 error if it doesn't exist
        $jobVacancy = JobVacancy::findOrFail($id);

        // dd($jobVacancy->jobApplication);

        // Return the view and pass the data to it
        return view('job-vacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the vacancy by ID, or throw a 404 error if it doesn't exist
        $jobVacancy = JobVacancy::findOrFail($id);
        $companies = Company::all();
        $categories = Jobcategory::all();

        return view('job-vacancy.edit', compact('jobVacancy', 'companies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validate = $request->validated();
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($validate);

        if ($request->query('redirectToList') != 'true') {
            return redirect()->route('job-vacancy.show', $jobVacancy->id)->with('success', 'Job Vacancy Updated Successfully');
        }

        return redirect()->route('job-vacancy.index')->with('success', 'Job Vacancy Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy deleted successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy restored successfully.');
    }
}
