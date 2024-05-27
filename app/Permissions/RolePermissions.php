<?php

declare(strict_types=1);

namespace App\Permissions;

class RolePermissions
{
    public const VIEW = [
        'name' => 'view Role',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Role',
    ];

    public const CREATE = [
        'name' => 'create Role',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to create Role',
    ];

    public const EDIT = [
        'name' => 'edit Role',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Role',
    ];

    public const DELETE = [
        'name' => 'delete Role',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Role',
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