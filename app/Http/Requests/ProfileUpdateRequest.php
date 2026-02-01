<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            
            'location' => ['nullable', 'string', 'max:255'],
            'location_manual' => ['nullable', 'required_if:location,Custom', 'string', 'max:255'],
            
            'pronouns' => ['nullable', 'string', 'max:255'],
            'pronouns_manual' => ['nullable', 'required_if:pronouns,Custom', 'string', 'max:255'],
        ];
    }
}