<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Route;

class ValidInertiaRoute implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Route::has($value)) {
            $fail(trans('validation.invalid_inertia_route'));
        }
    }
}
