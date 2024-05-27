<?php

declare(strict_types=1);

namespace App\Permissions;

class BoardPermissions
{
    public const VIEW = [
        'name' => 'view Board',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Board',
    ];

    public const CREATE = [
        'name' => 'create Board',
        'type' => 'companychairman',
        'description' => 'Allows a user of type `companychairman` to create Board',
    ];

    public const EDIT = [
        'name' => 'edit Board',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Board',
    ];

    public const DELETE = [
        'name' => 'delete Board',
        'type' => 'companychairman',
        'description' => 'Allows a user of type `companychairman` to delete Board',
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