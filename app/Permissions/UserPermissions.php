<?php

declare(strict_types=1);

namespace App\Permissions;

class UserPermissions
{
    public const CREATE = [
        'name' => 'create user',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to create users',
    ];

    public const EDIT = [
        'name' => 'edit user',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to edit users',
    ];

    public const VIEW = [
        'name' => 'view users',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to view users',
    ];
    public const VIEW_USER_PROFILE = [
        'name' => 'view user profile',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to view user profile',
    ];

    public const EDIT_SPECIFIC_FIELDS = [
        'name' => 'edit specific fields',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to edit specific fields',
    ];
    public const DELETE = [
        'name' => 'delete user',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to delete users',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::VIEW,
            self::VIEW_USER_PROFILE,
            self::DELETE,
            self::EDIT_SPECIFIC_FIELDS,
        ];
    }
}