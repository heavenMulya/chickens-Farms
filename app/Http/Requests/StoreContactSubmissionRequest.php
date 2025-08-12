<?php
namespace App\Http\Requests;

use App\Models\ContactSubmission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => ['required', Rule::in(array_keys(ContactSubmission::$subjects))],
            'message' => 'required|string|max:5000'
        ];
    }
}