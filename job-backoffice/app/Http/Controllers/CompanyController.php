<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::latest();

        if ($request->input("archive") == true) {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);
        return view("company.index", compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = Company::$industries;
        return view('company.create', compact('industries') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validate = $request->validated();
        //create owner
        $owner = User::create([
            'name' => $validate['owner_name'],
            'email' => $validate['owner_email'],
            'password' => Hash::make($validate['owner_password']),
            'role'=> 'company-owner',
        ]);

        //return error if owner creation failed
        if (!$owner) {
            return redirect()->route('company.create')->with('error','Failed to create owner. Please try again.');
        }

        //create company
        Company::create([
            'name' => $validate['name'],
            'address' => $validate['address'],
            'industry' => $validate['industry'],
            'website' => $validate['website'] ?? null,
            'ownerId' => $owner->id,
        ]);
        return redirect()->route('company.index')->with('success','Company Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::find($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        $industries = Company::$industries;
        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {


        $validate = $request->validated();
        $company = Company::findOrFail($id);
        $company->update([
            'name' => $validate['name'],
            'address' => $validate['address'],
            'industry' => $validate['industry'],
            'website' => $validate['website'] ?? null,

            ]);

            //update owner details
           $ownerData = [];
           $ownerData['name'] = $validate['owner_name'];
           if (!empty($validate['owner_password'])) {
               $ownerData['password'] = Hash::make($validate['owner_password']);
           }
           $company->owner->update($ownerData);
           if($request->query('redirectToList')=='false'){
            return redirect()->route('company.show', $company->id)->with('success','Company Updated Successfully');
           }

        return redirect()->route('company.index')->with('success','Company Updated Successfully');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('company.index')->with('success','Company Archived Successfully');
    }
    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('company.index',['archive'=>'true'])->with('success','Company Restored Successfully');
    }
}
