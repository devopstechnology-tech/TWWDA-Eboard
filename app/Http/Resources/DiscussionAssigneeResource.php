<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Models\Module\Member\Member;
use App\Http\Resources\MemberResource;
use App\Http\Resources\DiscussionResource;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class DiscussionAssigneeResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'discussion_id' => $this->resource->discussion_id,
            'discussion' => new DiscussionResource($this->resource->discussion),
            'user_id' => $this->resource->user_id,
            'user' => new UserResource($this->resource->user),
            'assignable_id' => $this->resource->assignable_id,
            'assignable_type' => $this->resource->assignable_type,
            'assignable' => [
                'type' => class_basename($this->assignable_type),  // Extracts simple class name
                'details' => $this->assignable,
            ],
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        $assignableType = class_basename($this->assignable_type);
        $isMemberable = $this->resource->assignable && method_exists($this->resource->assignable, 'memberable');
        
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'discussion_id' => $this->resource->discussion_id,
            'user_id' => $this->resource->user_id,
            'user' => $this->resource->user,
            'assignable' => [
                'type' => class_basename($this->assignable_type),  // Extracts simple class name
                'details' => $this->assignable,
                // 'is_memberable' => $isMemberable,
                // 'memberable_type' => $isMemberable ? class_basename($this->resource->assignable->memberable_type) : null,
                // 'memberable_details' => $isMemberable ?  $this->resource->assignable : null,
            ],
        ];
    }
}
