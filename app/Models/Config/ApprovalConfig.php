<?php

declare(strict_types=1);

namespace App\Models\Config;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalConfig extends BaseModel
{
    use HasFactory;
    use RequiresApproval;

    public function configurable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function requiresApprovalWhen(array $modifications): bool
    {
        if (app()->environment() === 'testing') {
            return false;
        }

        return true;
    }
}
