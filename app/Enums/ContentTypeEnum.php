<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self LINK_TO_VIEWPOINT()
 * @method static self INERTIA_ROUTE()
 * @method static self EXTERNAL_URL()
 * @method static self VIDEO()
 * @method static self INFO()
 */
final class ContentTypeEnum extends Enum
{
    protected static function labels(): Closure
    {
        return fn (string $name) => ucwords(strtolower(str_replace('_', ' ', $name)));
    }
}
