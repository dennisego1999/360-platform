<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreeSixtyAreaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'array',
                'required',
            ],
            'name.*' => [
                'string',
                'required',
                'max:255',
            ],
        ];
    }
}
