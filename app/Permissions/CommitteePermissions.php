<?php

declare(strict_types=1);

namespace App\Permissions;

class CommitteePermissions
{
    public const CREATE = [
        'name' => 'create committee',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to create committees',
    ];

    public const EDIT = [
        'name' => 'edit committee',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to edit committees',
    ];

    public const DELETE = [
        'name' => 'delete committee',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to delete committees',
    ];

    public const VIEW = [
        'name' => 'view committee',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to view committees',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::DELETE,
            self::VIEW,
        ];
    }
}