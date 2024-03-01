<?php

namespace App\Http\Requests;

use App\Enums\ContentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ThreeSixtyClickpointRequest extends FormRequest
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
            'coordinates' => [
                'required',
                'array',
            ],
            'coordinates.*' => [
                'required',
                'numeric',
            ],
            'content' => [
                'required',
                'array',
            ],
            'content.*.inertia_route' => [
                'nullable',
                'string',
                'max:255',
            ],
            'content.*.external_url' => [
                'nullable',
                'string',
                'max:255',
            ],
            'content.*.video' => [
                'nullable',
                'string',
                'max:255',
            ],
            'content.*.info' => [
                'nullable',
                'string',
                'max:255',
            ],
            'content.*.viewpoint_id' => [
                'nullable',
                'integer',
            ],
            'content_type' => [
                ['nullable', new EnumRule(ContentTypeEnum::class)]
            ],
        ];
    }
}
