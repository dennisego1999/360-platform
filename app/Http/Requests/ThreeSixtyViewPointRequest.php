<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThreeSixtyViewPointRequest extends FormRequest
{
    public function rules(): array
    {
        // Get viewpoint
        $viewpointId = $this->route('viewpoint') ? $this->route('viewpoint')->id : null;

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
                Rule::unique('App\Models\Viewpoint')->ignore($viewpointId),
            ],
            'new_image' => [
                'image',
                'mimes:jpg,png,jpeg,gif',
                'nullable'
            ],
        ];
    }
}
