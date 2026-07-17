<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'country' => ['nullable', 'string', 'max:80'],
            'message' => ['nullable', 'string', 'max:5000'],

            // Honeypot — must stay empty.
            'website' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'website.prohibited' => 'Your submission looked automated. Please try again.',
        ];
    }

    /** Send failed validation back to the form rather than the top of the page. */
    protected function getRedirectUrl(): string
    {
        return route('home').'#contact';
    }
}
