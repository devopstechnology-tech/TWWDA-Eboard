<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class RoleResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'permissions_count' => $this->resource->permissions_count,
            'users_count' => $this->resource->users_count,
            'users' => $this->resource->users()->get(),
            'permissions' => $this->resource->permissions()->get(),
        ];
    }
    #[Format('single')]
    public function single(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'permissions_count' => $this->resource->permissions_count,
        ];
    }
}
