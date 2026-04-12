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
            'name'           => ['required', 'string', 'max:255'],
            'email'          => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone'          => ['nullable', 'string', 'max:20'],
            'avatar'         => ['nullable', 'string', 'max:50'],
            'bio'            => ['nullable', 'string', 'max:500'],
            'tags'           => ['nullable', 'array'],
            'tags.*'         => ['string', 'max:30'],
            // Client fields
            'company'        => ['nullable', 'string', 'max:255'],
            'country'        => ['nullable', 'string', 'max:255'],
            'website'        => ['nullable', 'url', 'max:255'],
            'industry'       => ['nullable', 'string', 'max:255'],
            'social_linkedin'=> ['nullable', 'url', 'max:255'],
            'social_facebook'=> ['nullable', 'url', 'max:255'],
            'timezone'       => ['nullable', 'string', 'max:255'],
            'birthday'       => ['nullable', 'date'],
        ];
    }
}
