<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class StaffResource extends BaseResource
{
    public const AUTHENTICATED = 'authenticated';
    public const LOGIN = 'login';
    public const WITH_META = 'with_meta';

    #[Format(self::AUTHENTICATED), IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'full_name' => $this->resource->full_name,
            'first' => $this->resource->first,
            'last' => $this->resource->last,
            'title' => $this->resource->title,
            'id_number' => $this->resource->id_number,
            // 'department' => $this->resource->department,
            'pos' => $this->resource->pos,
            'phone' => $this->resource->phone,
            'email' => $this->resource->email,
            'serial_number' => $this->resource->serial_no,
            'status' => $this->resource->status,
            'description' => $this->resource->description,
            'image' => $this->resource->image,
            'access_key' => $this->resource->access_key,
            'access_secret' => $this->resource->access_secret,
            'login_status' => $this->resource->login_status,
            'last_login_at' => $this->resource->last_login_at,
            'last_login_ip' => $this->resource->last_login_ip,
        ];
    }

    #[Format(self::WITH_META)]
    public function withMeta(): array
    {
        return [
            'staff' => StaffResource::make($this->resource),
            'access_key' => $this->resource->access_key,
            'access_secret' => $this->resource->access_secret,
            'login_status' => $this->resource->login_status,
            'last_login_at' => $this->resource->last_login_at,
            'last_login_ip' => $this->resource->last_login_ip,
        ];
    }

    #[Format(self::LOGIN)]
    public function login($token): array
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'user' => StaffResource::make($this->resource)->format(self::WITH_META),
        ];
    }
}
