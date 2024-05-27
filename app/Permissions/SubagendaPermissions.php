<?php

declare(strict_types=1);

namespace App\Permissions;

class SubagendaPermissions
{
    public const VIEW = [
        'name' => 'view SubAgenda',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view SubAgenda',
    ];

    public const CREATE = [
        'name' => 'create SubAgenda',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to create SubAgenda',
    ];

    public const EDIT = [
        'name' => 'edit SubAgenda',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit SubAgenda',
    ];

    public const DELETE = [
        'name' => 'delete SubAgenda',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to delete SubAgenda',
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