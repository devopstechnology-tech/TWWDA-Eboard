<?php

declare(strict_types=1);

namespace App\Enums;

trait BaseEnumTrait
{
    public static function values(): array
    {
        return array_map(function ($case) {
            return $case->value;
        }, self::cases());
    }

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
