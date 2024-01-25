<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\JobSeeker;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobSeekerRequest;

class JobSeekerController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all job seekers with their names and profiles
        $jobSeekers = JobSeeker::with('user')->get();

        return $this->success([
            'jobSeekers' => $jobSeekers,
            'message' => 'Job seekers retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobSeekerRequest $request)
    {
        $user = $request->user();

        $request->validated($request->all());

        if ($user->role === UserRole::JobSeeker->value) {
            
            $profile = $user->job_seeker;
    
            if ($profile) {
                return $this->error('', 'User already has a profile', 400);
            }
    
            // User doesn't have a job seeker profile, create it
            $profile = $user->job_seeker()->create([
                'phone_number' => $request->phone_number,
                'current_company' => $request->current_company,
                'previous_company' => $request->previous_company,
                'work_experience' => $request->work_experience,
            ]);
    
            return $this->success([
                'profile' => $profile,
                'message' => 'Profile created successfully'
            ]);
        }
    
        return $this->error('', 'User is not a job seeker', 400);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobSeeker = JobSeeker::with('user')->find($id);

        if (!$jobSeeker) {
            // Handle the case when no job seeker is found with the given ID
            return $this->error('', 'Job seeker not found', 400);
        }

        return $this->success([
            ' jobSeeker' =>  $jobSeeker,
            'message' => 'Job seeker retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreJobSeekerRequest $request, string $id)
    {
        $jobSeeker = JobSeeker::find($id);

        if (!$jobSeeker) {

            return $this->error('', 'Job seeker not found', 404);
        }

        // Update the job seeker with the provided fields
        $jobSeeker->fill($request->only(['phone_number', 'current_company', 'previous_company', 'work_experience']));
        $jobSeeker->save();

        return $this->success([
            'jobSeeker' => $jobSeeker,
            'message' => 'Job seeker updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobSeeker = JobSeeker::find($id);

        if (!$jobSeeker) {

            return $this->error('', 'Job seeker not found', 404);
        }

         // Delete the associated user
        $user = $jobSeeker->user;
        $user->delete();

        // Delete the job seeker
        $jobSeeker->delete();

        return $this->success([
            'jobSeeker' => $jobSeeker,
            'message' => 'Job seeker deleted successfully'
        ]);
    
    }
}
