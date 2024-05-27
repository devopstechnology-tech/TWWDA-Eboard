<?php

declare(strict_types=1);

namespace App\Permissions;

class ProfilePermissions
{
    public const VIEW = [
        'name' => 'view Profile',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Profile',
    ];

    public const CREATE = [
        'name' => 'create Profile',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to create Profile',
    ];

    public const EDIT = [
        'name' => 'edit Profile',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Profile',
    ];

    public const DELETE = [
        'name' => 'delete Profile',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to delete Profile',
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