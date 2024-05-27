<?php

declare(strict_types=1);

namespace App\Permissions;

class OptionPermissions
{
    public const VIEW = [
        'name' => 'view Option',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Option',
    ];

    public const CREATE = [
        'name' => 'create Option',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create Option',
    ];

    public const EDIT = [
        'name' => 'edit Option',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit Option',
    ];

    public const DELETE = [
        'name' => 'delete Option',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Option',
    ];
    public const APPROVE = [
        'name' => 'approve Option',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to approve Option',
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