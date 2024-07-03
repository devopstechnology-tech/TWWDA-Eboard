<?php

declare(strict_types=1);

namespace App\Permissions;

class PermisionPermissions
{
    public const CREATE = [
        'name' => 'create permision',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to create permisions',
    ];

    public const UPDATE = [
        'name' => 'update permision',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to update permisions',
    ];

    public const VIEW = [
        'name' => 'view permision',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to view permisions',
    ];

    public const DELETE = [
        'name' => 'delete permision',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to delete permisions',
    ];
    public const ASSIGN_PERMISION = [
        'name' => 'assign user permision',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to assign permisions in users',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::UPDATE,
            self::VIEW,
            self::DELETE,
            self::ASSIGN_PERMISION,
        ];
    }
}