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
        $userId = $this->route('user') ?? $this->id_edit; // Get the user ID for update

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId, // Exclude the current user's email
            'role' => 'required|in:Admin,User', // Assuming roles are either Admin or User
        ];

        if ($this->isMethod('post')) { // Add user
            $rules['password'] = [
                'required',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ];
        } else if ($this->isMethod('put')) { // Update user
            $rules['password'] = [
                'nullable',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ];
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
        ];
    }
}