<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            
            'company_name' => [$this->isPostRequest(), 'string', 'max:225', 'unique:companies'],
            'contact_email' => [$this->isPostRequest(), 'string', 'max:225', 'unique:companies'],
            'contact_phone' => [$this->isPostRequest(), 'string', 'max:225', 'unique:companies'],
            'address' => [$this->isPostRequest(), 'string', 'max:225'],
        ];

    }

    // this method check if the request is "post" request or any other request
    // and if not a "post" request this means that the request is "put" so we can update any field we want
    private function isPostRequest() {

        return request()->isMethod('post') ? 'required' : 'sometimes';
    }
}
