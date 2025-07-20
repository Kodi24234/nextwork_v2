<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'headline'        => ['nullable', 'string', 'max:255'],
            'location'        => ['nullable', 'string', 'max:255'],
            'summary'         => ['nullable', 'string'],
            'website_url'     => ['nullable', 'url'],
            'linkedin_url'    => ['nullable', 'url'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
        ];

    }
}
