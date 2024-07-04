<?php

declare(strict_types=1);

namespace App\Permissions;

class ConflictPermissions
{
    public const CREATE = [
        'name' => 'create conflict of interest',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to create a conflict of interest',
    ];

    public const EDIT = [
        'name' => 'edit conflict of interest',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to edit a conflict of interest',
    ];

    public const VIEW = [
        'name' => 'view conflicts of interest',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to view own conflict of interest',
    ];
    public const VIEW_ALL_CONFLICTS = [
        'name' => 'view conflicts of interests',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to view all conflict of interest',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::VIEW,
            self::VIEW_ALL_CONFLICTS,
        ];
    }
}