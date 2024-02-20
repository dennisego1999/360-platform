<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThreeSixtyAreaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'required',
                'max:255',
            ],
        ];
    }
}
