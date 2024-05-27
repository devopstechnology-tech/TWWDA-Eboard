<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class BoardResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        // dd('me');

        // if (!$this->resource->relationLoaded('owner')) {
        //     $this->resource->load('owner');
        // }
        // if (!$this->resource->relationLoaded('members')) {
        //     $this->resource->load('members.user');//fecthing only user
        // }
        // if (!$this->resource->relationLoaded('folders')) {
        //     $this->resource->load('folders');//fecthing only user id
        // }
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'owner_id' => $this->resource->owner_id,
            'owner' => $this->owner->full_name,
            'icon' => $this->resource->icon,
            'cover' => $this->resource->cover,
            'members' => $this->resource->members,
            'folders' => $this->resource->folders,
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        return [
            // Short resource fields here
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            // 'owner' => $this->whenLoaded('owner', $this->resource->owner->full_name,''),
            'owner_id' => $this->resource->owner_id,
            'icon' => $this->resource->icon,
            'cover' => $this->resource->cover,
            // 'members' => $this->whenLoaded('members',
            //           UserResource::collection($this->resource->members), []),
        ];
    }
}
