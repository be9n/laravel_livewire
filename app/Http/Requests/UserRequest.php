<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules($edit = false): array
    {
        $rules = [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email,'.$this->id,
        ];

        if ($edit) {
            $rules['password'] = 'sometimes|required|confirmed';
        } else {
            $rules['password'] = 'required|confirmed';
        }

        return $rules;
    }

    public function withState(array $state)
    {
        $this->merge($state);

        return $this->duplicate($state);
    }

}
