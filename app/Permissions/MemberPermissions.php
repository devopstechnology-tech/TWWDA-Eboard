<?php

declare(strict_types=1);

namespace App\Permissions;

class MemberPermissions
{
    public const VIEW = [
        'name' => 'view Member',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Member',
    ];

    public const CREATE = [
        'name' => 'create Member',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to create Member',
    ];

    public const EDIT = [
        'name' => 'edit Member',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Member',
    ];

    public const DELETE = [
        'name' => 'delete Member',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to delete Member',
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