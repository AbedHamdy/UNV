<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $this->route('id'),
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'course_id' => 'required|exists:courses,id',
        ];
    }
}
