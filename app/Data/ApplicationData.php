<?php

declare(strict_types=1);

namespace App\Data;

class ApplicationData
{
    public function __construct(
        public readonly string $lat = '',
        public readonly string $lang = '',
    ) {
        //
    }
}
