<?php

declare(strict_types=1);

namespace App\Permissions;

class MeetingPermissions
{
    public const VIEW = [
        'name' => 'view Meeting',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Meeting',
    ];

    public const CREATE = [
        'name' => 'create Meeting',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to create Meeting',
    ];

    public const EDIT = [
        'name' => 'edit Meeting',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to edit Meeting',
    ];

    public const DELETE = [
        'name' => 'delete Meeting',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Meeting',
    ];
    public static function allPermissions(): array
    {
        return [
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,        ];
    }
}