<?php

namespace App\Rules;

use App\Models\ThreeSixtyViewPoint;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueDefaultThreeSixtyViewPoint implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Count the number of records with is_default set to true
        $count = ThreeSixtyViewPoint::where($attribute, true)->count();

        if($count === 1 && $value) {
            // Fail
            $fail(trans('validation.is_default'));
        }
    }
}
