<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThreeSixtyViewpointRequest extends FormRequest
{
    public function rules(): array
    {
        // Get viewpoint
        $viewpointId = $this->route('viewpoint') ? $this->route('viewpoint')->id : null;
        $areaId = $this->route('area') ? $this->route('area')->id : null;


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
            'description' => [
                'array',
                'required',
            ],
            'description.*' => [
                'string',
                'required',
                'max:255',
            ],
            'initial_view' => [
                'array',
                'required',
            ],
            'initial_view.pitch' => [
                'integer',
                'required',
            ],
            'initial_view.yaw' => [
                'required',
                'integer',
            ],
            'is_default' => [
                'boolean',
                'required',
                Rule::unique('viewpoints')
                    ->where('area_id', $areaId)
                    ->where('is_default', true)
                    ->where(function ($query) use ($viewpointId) {
                        if ($viewpointId !== null) {
                            $query->where('id', '!=', $viewpointId);
                        }
                    }),
            ],
            'new_image' => [
                'image',
                'mimes:jpg,png,jpeg,gif',
                'nullable',
            ],
        ];
    }
}
