<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;

class CompanyController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Retrieve all companies with their names and profiles
         $companies = Company::with('user')->get();

         return $this->success([
             'companies' => $companies,
             'message' => 'Companies retrieved successfully'
         ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        // note: before create a company we should first login and then put the token in the postman in order to create a company this is just for now in the developement
        
        $user = $request->user();

        $request->validated($request->all());

        if ($user->role === UserRole::Company->value) {
            
            $profile = $user->company;
    
            if ($profile) {

                return $this->error('', 'User already has a profile', 400);
            }

            // User doesn't have a company profile, create it
            $profile = $user->jobs()->create([
                'company_name' => $request->company_name,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'address' => $request->address,
            ]);
    
            return $this->success([
                'profile' => $profile,
                'message' => 'Profile created successfully'
            ]);
        }

        return $this->error('', 'User is not a company', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::with('user')->find($id);

        if (!$company) {
            // Handle the case when no company is found with the given ID
            return $this->error('', 'Company not found', 400);
        }

        return $this->success([
            ' company' =>  $company,
            'message' => 'Company retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCompanyRequest $request, string $id)
    {
        
        $company = Company::find($id);

        if (!$company) {

            return $this->error('', 'Company not found', 404);
        }

        // Update the company with the provided fields
        $company->fill($request->only(['company_name', 'contact_email', 'contact_phone', 'address']));
        $company->save();

        return $this->success([
            'company' => $company,
            'message' => 'company updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::find($id);

        if (!$company) {

            return $this->error('', 'Company not found', 404);
        }

         // Delete the associated user
        $user = $company->user;
        $user->delete();

        // Delete the Company 
        $company->delete();

        return $this->success([
            'Company' => $company,
            'message' => 'Company deleted successfully'
        ]);
    }
}
