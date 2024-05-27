<?php

declare(strict_types=1);

namespace App\Permissions;

class CommitteePermissions
{
    public const VIEW = [
        'name' => 'view Committee',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Committee',
    ];

    public const CREATE = [
        'name' => 'create Committee',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to create Committee',
    ];

    public const EDIT = [
        'name' => 'edit Committee',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Committee',
    ];

    public const DELETE = [
        'name' => 'delete Committee',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to delete Committee',
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