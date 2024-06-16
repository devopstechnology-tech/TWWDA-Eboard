<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class UsersResource extends BaseResource
{
    public const AUTHENTICATED = 'authenticated';

    #[Format(self::AUTHENTICATED), IsDefault]
    public function base(): array
    {
        return [
            'created_at' => $this->resource->created_at,
            'email' => $this->resource->email,
            'first' => $this->resource->first,
            'full_name' => $this->resource->full_name,
            'other_names' => $this->resource->other_names,
            'id' => $this->resource->getRouteKey(),
            'last' => $this->resource->last,
            'membs' => $this->resource->membs,
            'permissions' => Arr::flatten($this->resource->roles->map(fn ($role) => $role->permissions)),
            'role' => $this->resource->role,
            'roles' => $this->resource->roles,
            'rolenames' => Arr::flatten($this->resource->roles->map(fn ($role) => $role->name)),
            'status' => $this->resource->status,
            'type' => $this->resource->type,
            'profile' => $this->resource->profile,
            'updated_at' => $this->resource->updated_at,

        ];
    }
}