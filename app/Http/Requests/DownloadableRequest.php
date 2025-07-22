<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'nullable',
            'ra_jr_no' => 'nullable',
            'source_priority_level' => 'nullable',
            'approved_on' => 'nullable',
            'congress' => 'nullable',
            'long_title' => 'nullable',
            // 'attachments' => 'nullable',
            'bill_no' => 'nullable',
            'proposed_measure' => 'nullable',
            'status' => 'nullable'
        ];
    }
}
