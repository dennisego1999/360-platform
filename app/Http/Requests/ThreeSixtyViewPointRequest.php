<?php

namespace App\Http\Requests;

use App\Rules\UniqueDefaultThreeSixtyViewPoint;
use Illuminate\Foundation\Http\FormRequest;

class ThreeSixtyViewPointRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'required',
                'max:255',
            ],
            'description' => [
                'string',
                'required',
                'max:255',
            ],
            'is_default' => [
                'boolean',
                'required',
                new UniqueDefaultThreeSixtyViewPoint,
            ],
            'new_image' => [
                'image',
                'mimes:jpg,png,jpeg,gif',
                'nullable'
            ],
        ];
    }
}
