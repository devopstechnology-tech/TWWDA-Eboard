<?php

declare(strict_types=1);

namespace App\Permissions;

class AlmanacPermissions
{
    public const VIEW = [
        'name' => 'view Almanac',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Almanac',
    ];

    public const CREATE = [
        'name' => 'create Almanac',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to create Almanac',
    ];

    public const EDIT = [
        'name' => 'edit Almanac',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to edit Almanac',
    ];

    public const DELETE = [
        'name' => 'delete Almanac',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Almanac',
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