<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use App\Models\Config\Setting;
use App\Http\Resources\SettingResource;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class UserResource extends BaseResource
{
    public const AUTHENTICATED = 'authenticated';
    public const LOGIN = 'login';
    public const WITH_META = 'with_meta';
    public const WITH_ROLES = 'with_roles';
    public const SIMPLEUSER = 'simple_user';

    #[Format(self::AUTHENTICATED), IsDefault]
    public function base(): array
    {
        return [
            'email' => $this->resource->email,
            'first' => $this->resource->first,
            'full_name' => $this->resource->full_name,
            'other_names' => $this->resource->other_names,
            'id' => $this->resource->getRouteKey(),
            'last' => $this->resource->last,
            'permissions' => Arr::flatten($this->resource->roles->map(fn ($role) => $role->permissions)),
            'role' => $this->resource->role,
            'status' => $this->resource->status,
            'type' => $this->resource->type,
            'profile' => $this->resource->profile,
            'membership' => $this->resource->membership,
        ];
    }
    #[Format(self::SIMPLEUSER)]
    public function simple(): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->full_name, // Assuming 'full_name' is the attribute you want.
            'email' => $this->resource->email,
        ];
    }

    #[Format(self::LOGIN)]
    public function login($token): array
    {
        //        return $this->modify([
        //            'token' => $token,
        //            'token_type' => 'bearer',
        //        ]);
        // $setting = SettingResource::make(Setting::first());
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'user' => UserResource::make($this->resource)->format(self::AUTHENTICATED),
            'setting' => SettingResource::make(Setting::first()),
        ];
    }

    #[Format(self::WITH_ROLES)]
    public function withRoles(): array
    {
        return [
            'created_at' => $this->resource->created_at,
            'email' => $this->resource->email,
            'first_name' => $this->resource->first,
            'other_names' => $this->resource->other_names,
            'id' => $this->resource->getRouteKey(),
            'last_name' => $this->resource->last,
            'permissions' => $this->resource->permissions(),
            'roles' => Arr::flatten($this->resource->roles->map(fn ($role) => $role->name)),
            'updated_at' => $this->resource->updated_at,
        ];
    }

    #[Format(self::WITH_META)]
    public function withMeta(): array
    {
        return [
            'last_login_at' => $this->resource->last_login_at,
            'last_login_ip' => $this->resource->last_login_ip,
            'login_status' => $this->resource->login_status,
            'permissions' => Arr::flatten($this->resource->roles->map(fn ($role) => $role->permissions)),
            'user' => UserResource::make($this->resource),
        ];
    }
}