<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;
use App\Models\Jobcategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jobcategory::latest();

        if ($request->input("archive") == true) {
            $query->onlyTrashed();
        }

        $categories = $query->paginate(10)->onEachSide(1);
        return view("job-category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        Jobcategory::create($request->all());
        return redirect()->route('job-category.index')->with('success','Job Category Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Jobcategory::findOrFail($id);
        return view('job-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $validate = $request->validated();
        $category = Jobcategory::findOrFail($id);
        $category->update($validate);
        return redirect()->route('job-category.index')->with('success','Job Category Updated Successfully');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Jobcategory::findOrFail($id);
        $category->delete();
        return redirect()->route('job-category.index')->with('success','Job Category Archived Successfully');
    }
    public function restore(string $id)
    {
        $category = Jobcategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('job-category.index',['archive'=>'true'])->with('success','Job Category Restored Successfully');
    }
}
