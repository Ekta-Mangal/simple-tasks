<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // You can add authorization logic here or return true if all users are allowed.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|numeric',
            'priority' => 'required|string',
            'due_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The task title is required.',
            'description.required' => 'Please provide a description for the task.',
            'due_date.required' => 'The due date is required.',
            'due_date.date' => 'The due date must be a valid date.',
            'priority.required' => 'Please select a priority for the task.',
            'priority.in' => 'Priority must be one of the following: High, Medium, or Low.',
            'user_id.required' => 'Please assign the task to a user.',
            'user_id.exists' => 'The selected user does not exist.',
        ];
    }
}