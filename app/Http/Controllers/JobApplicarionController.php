<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobSeeker;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\JobApplication;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobApplicationRequest;

class JobApplicarionController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $jobApplication = JobApplication::with(['job', 'job_seeker.user:id,name'])->get();

        if ($jobApplication->isEmpty()) {
            return $this->error('No jobs available', 404);
        }

        return $this->success([
            'jobApplication' => $jobApplication,
            'message' => 'Jobs retrieved successfully'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobApplicationRequest $request)
    {

        $validatedData = $request->validated();

        // Get the job and job seeker
        $job = Job::find($validatedData['job_id']);
        $jobSeeker = JobSeeker::find($validatedData['job_seeker_id']);

        // Check if the job or job seeker exists
        if (!$job || !$jobSeeker) {
            return $this->error('', 'Invalid job or job seeker', 400);
        }

        // Create a new job application
        $jobApplication = JobApplication::create([
            'job_id' => $job->id,
            'job_seeker_id' => $jobSeeker->id,
        ]);

        return $this->success([
            'jobApplication' => $jobApplication,
            'message' => 'Applied for the job successfully',
        ]);



        // $request->validated($request->all());

        // // Get the job and job seeker
        // $job = Job::find($job_id);
        // $jobSeeker = JobSeeker::find($job_seeker_id);

                
        // // Create a new job application
        // $jobApplication = JobApplication::create([
        //     'job_id' => $request->job_id,
        //     'job_seeker_id' => $request->job_seeker_id,
        // ]);


        // return $this->success([
        //             'jobApplication' => $jobApplication,
        //             'message' => 'applied for the job successfully'
        //         ]);
            

        // if($jobApplication) {

        //     return $this->success([
        //         'jobs' => $jobs,
        //         'message' => 'applied for the job successfully'
        //     ]);
        // }

        // return $this->error('No jobs available', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
