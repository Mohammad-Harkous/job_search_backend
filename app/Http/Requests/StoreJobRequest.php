<?php

namespace App\Http\Requests;

use App\Enums\JobType;
use App\Enums\JobLocation;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'job_title' => [$this->isPostRequest(), 'string', 'max:225'],
            'job_type' => [$this->isPostRequest(),  new Enum(JobType::class)],
            'job_location' => [$this->isPostRequest(),  new Enum(JobLocation::class)],
            'salary' => [$this->isPostRequest(), 'integer'],
            'description' => [$this->isPostRequest(), 'string'],
            'application_deadline' => [$this->isPostRequest(), 'Date']

        ];
    }


    private function isPostRequest() {

        return request()->isMethod('post') ? 'required' : 'sometimes';
    }
}
