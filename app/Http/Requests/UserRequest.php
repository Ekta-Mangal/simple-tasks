<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user') ?? $this->id_edit;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($userId ? $userId : ''),
            'role' => 'required|in:Admin,User',
            'phone' => 'required|string|max:15',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'postcode' => 'required|string|max:20',
            'country' => 'required|integer',
        ];

        if ($this->isMethod('post')) {
            if ($this->has('id_edit') && !empty($this->id_edit)) {
                $rules['password'] = [
                    'nullable',
                    'min:6',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ];
            } else {
                $rules['password'] = [
                    'required',
                    'min:6',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ];
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters long.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one symbol, and one number.',
            'role.required' => 'Please select a user role.',
            'role.in' => 'The role must be either Admin or User.',
            'phone.required' => 'The phone field is required.',
            'address1.required' => 'The address line 1 field is required.',
            'address2.required' => 'The address line 2 field is required.',
            'postcode.required' => 'The postcode field is required.',
            'country.required' => 'The country field is required.',
        ];
    }
}