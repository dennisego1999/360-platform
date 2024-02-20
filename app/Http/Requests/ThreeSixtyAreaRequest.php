<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThreeSixtyAreaRequest extends FormRequest
{
    public function rules(): array
    {
        // Get three sixty area id from request
        $areaId = $this->route('three_sixty_area') ? $this->route('three_sixty_area')->id : null;

        return [
            'name' => [
                'string',
                'required',
                'max:255',
                Rule::unique('App\Models\ThreeSixtyArea')->ignore($areaId),
            ],
            'slug' => [
                'string',
                'required',
                'max:255',
                Rule::unique('App\Models\ThreeSixtyArea')->ignore($areaId),
            ],
            'is_default' => [
                'boolean',
                'required',
                Rule::unique('App\Models\ThreeSixtyArea')->ignore($areaId),
            ],
            'new_image' => [
                'image',
                'mimes:jpg,png,jpeg,gif',
                'nullable'
            ],
        ];
    }
}
