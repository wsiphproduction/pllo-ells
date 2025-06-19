<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return auth()->check();
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
            'title' => 'required',
            'description' => 'required',
            'event_cluster_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            // 'attachments' => 'nullable',
            // 'event_img' => 'nullable',
            'cluster_id' => 'nullable',
            'agency_id' => 'nullable',
            'member_id' => 'nullable',
            'participant_limit' => 'nullable',
            'invitation_file' => 'nullable',
            'individual_invitation_agency_ids' => 'nullable',
            'individual_invitation_file' => 'nullable'
        ];
    }
}
