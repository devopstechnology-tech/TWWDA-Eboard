<?php

declare(strict_types=1);

namespace App\Permissions;

class PollPermissions
{
    public const VIEW = [
        'name' => 'view Poll',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Poll',
    ];

    public const CREATE = [
        'name' => 'create Poll',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create Poll',
    ];

    public const EDIT = [
        'name' => 'edit Poll',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit Poll',
    ];

    public const DELETE = [
        'name' => 'delete Poll',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Poll',
    ];
    public const APPROVE = [
        'name' => 'approve Poll',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to approve Poll',
    ];
    public static function allPermissions(): array
    {
        return [
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,self::APPROVE,
        ];
    }
}