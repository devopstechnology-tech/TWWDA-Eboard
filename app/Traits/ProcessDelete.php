<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;

trait ProcessDelete
{
    public function processDelete(): ?bool
    {
        $this->update(['deleted' => (string) Str::uuid()]);

        return $this->delete();
    }
}
