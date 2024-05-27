<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class ModificationResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey() ?? '--',
            'modifiable' => $this->resource->modifiable_type ?? '--',
            'modifier' => $this->resource->modifier_type ?? '--',
            'active' => $this->resource->active ? 'True' : 'False',
            'action' => $this->resource->action,
            'is_update' => $this->resource->is_update ? 'Update' : 'Creation',
            'approvers_required' => $this->resource->approvers_required,
            'disapprovers_required' => $this->resource->disapprovers_required,
            'modifications' => $this->resource->modifications,
        ];
    }
}
