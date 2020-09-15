<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class notInNull implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return $value != "NULL";
    }

    public function message()
    {
        return ':attribute harus dipilih.';
    }
}
