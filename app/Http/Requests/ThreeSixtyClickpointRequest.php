<?php

namespace App\Http\Requests;

use App\Enums\ContentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ThreeSixtyClickpointRequest extends FormRequest
{
    public function rules(): array
    {
        // Get viewpoint
        $viewpointId = $this->route('viewpoint') ? $this->route('viewpoint')->id : null;

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
                'integer',
            ],
            'content' => [
                'array',
                'required',
            ],
            'content.*' => [
                'string',
                'required',
                'max:255',
            ],
            'content_type' => [
                ['nullable', new EnumRule(ContentTypeEnum::class)]
            ],
        ];
    }
}
