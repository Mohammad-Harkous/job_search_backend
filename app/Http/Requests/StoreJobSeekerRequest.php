<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\AuthController;


class StoreJobSeekerRequest extends FormRequest
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
            'phone_number' => [$this->isPostRequest(), 'string'],
            'current_company' => [$this->isPostRequest(), 'string', 'max:225'],
            'previous_company' => [$this->isPostRequest(), 'string', 'max:225'],
            'work_experience' => [$this->isPostRequest(), 'integer'],
        ];

    }

    // this method check if the request is "post" request or any other request
    // and if not a "post" request this means that the request is "put" so we can update any field we want
    private function isPostRequest() {

        return request()->isMethod('post') ? 'required' : 'sometimes';
    }
}
