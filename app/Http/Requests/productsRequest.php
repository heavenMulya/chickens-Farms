<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productsRequest extends FormRequest
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
   // app/Http/Requests/productsRequest.php

public function rules()
{
    // If it's an update request, skip image required
    if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
        return [
            'name' => 'required|string',
            'discount' => 'nullable|numeric',
            'price' => 'required|numeric',
            'status' => 'required|string',
            'batch_type' => 'nullable|string',
            'description' => 'required|string',
            'image' => 'nullable|file', // not required in update
        ];
    }

    // For store
    return [
        'name' => 'required|string',
        'discount' => 'nullable|numeric',
        'price' => 'required|numeric',
        'status' => 'required|string',
        'batch_type' => 'required|string',
        'description' => 'required|string',
        'image' => 'required|file',
    ];
}

}
