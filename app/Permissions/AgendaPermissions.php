<?php

declare(strict_types=1);

namespace App\Permissions;

class AgendaPermissions
{
    public const VIEW = [
        'name' => 'view Agenda',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Agenda',
    ];

    public const CREATE = [
        'name' => 'create Agenda',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to create Agenda',
    ];

    public const EDIT = [
        'name' => 'edit Agenda',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Agenda',
    ];

    public const DELETE = [
        'name' => 'delete Agenda',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to delete Agenda',
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