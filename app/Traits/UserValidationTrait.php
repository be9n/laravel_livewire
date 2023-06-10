<?php

namespace App\Traits;

trait UserValidationTrait
{

    protected $realTimeRules = [
        'state.name' => 'required|min:6',
        'state.email' => 'required|email|unique:users,email',
    ];

    function rules($id = null)
    {
        return [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email,'. @$id,
        ];
    }
}
