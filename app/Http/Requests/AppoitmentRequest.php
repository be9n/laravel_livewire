<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppoitmentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'client_id' => 'required',
            'date' => 'required',
            'status' => 'required',
            'time' => 'required',
        ];

        return $rules;
    }

    public function withState(array $state)
    {
        $this->merge($state);

        return $this->duplicate($state);
    }
}
