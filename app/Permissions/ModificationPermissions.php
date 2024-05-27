<?php

declare(strict_types=1);

namespace App\Permissions;

class ModificationPermissions
{
    public const VIEW = [
        'name' => 'view Modification',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Modification',
    ];

    public const CREATE = [
        'name' => 'create Modification',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to create Modification',
    ];

    public const EDIT = [
        'name' => 'edit Modification',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to edit Modification',
    ];

    public const DELETE = [
        'name' => 'delete Modification',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Modification',
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