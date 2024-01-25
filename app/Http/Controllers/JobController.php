<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Enums\JobType;
use App\Enums\UserRole;
use App\Enums\JobLocation;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;

class JobController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $jobs = Job::with('company')->get();


        $jobs = Job::with(['company' => function ($query) {
            $query->select( 'id','company_name', 'contact_email', 'contact_phone', 'address');
        }])->get();

        
        if ($jobs->isEmpty()) {
            return $this->error('No jobs available', 404);
        }

        return $this->success([
            'jobs' => $jobs,
            'message' => 'Jobs retrieved successfully'
        ]);

    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        $user = $request->user();

        $request->validated($request->all());

        if ($user->role !== UserRole::Company->value) {
            
            return $this->error('', 'User is not a company', 400);
        }
        
         // Format the application_deadline value
        $applicationDeadline = Carbon::createFromFormat('d-m-Y', $request->application_deadline)->format('Y-m-d');
        
        // Create a job with the association to the company
        $job = $user->company->jobs()->create([
            'job_title' => $request->job_title,
            'job_type' => $request->job_type,
            'job_location' => $request->job_location,
            'salary' => $request->salary,
            'description' => $request->description,
            'application_deadline' => $applicationDeadline,
        ]);


        return $this->success([
            'job' => $job,
            'message' => 'Job created successfully'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::with(['company' => function ($query) {
            $query->select( 'id','company_name', 'contact_email', 'contact_phone', 'address');
        }])->find($id);

        if(!$job) {
            // Handle the case when no company is found with the given ID
            return $this->error('', 'Job not found', 400);
        }

        return $this->success([
            'job' =>  $job,
            'message' => 'Job retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreJobRequest $request, string $id)
    {
        $job = Job::find($id);

        if (!$job) {

            return $this->error('', 'Job not found', 404);
        }

        // Update the company with the provided fields
        $job->fill($request->only(['job_title', 'job_type', 'job_location', 'salary','description','application_deadline']));
        $job->save();

        return $this->success([
            'job' => $job,
            'message' => 'job updated successfully'
        ]);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $job = Job::find($id);

        if (!$job) {

            return $this->error('', 'Job not found', 404);
        }


        
        // Delete the job
        $job->delete();

        return $this->success([
            'Job' => $job,
            'message' => 'job deleted successfully'
        ]);
    }
}
