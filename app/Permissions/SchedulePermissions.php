<?php

declare(strict_types=1);

namespace App\Permissions;

class SchedulePermissions
{
    public const VIEW = [
        'name' => 'view Schedule',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Schedule',
    ];

    public const CREATE = [
        'name' => 'create Schedule',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create Schedule',
    ];

    public const EDIT = [
        'name' => 'edit Schedule',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit Schedule',
    ];

    public const DELETE = [
        'name' => 'delete Schedule',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Schedule',
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