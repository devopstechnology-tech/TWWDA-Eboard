<?php

declare(strict_types=1);

namespace App\Permissions;

class FolderPermissions
{
    public const VIEW = [
        'name' => 'view Folder',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Folder',
    ];

    public const CREATE = [
        'name' => 'create Folder',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to create Folder',
    ];

    public const EDIT = [
        'name' => 'edit Folder',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Folder',
    ];

    public const DELETE = [
        'name' => 'delete Folder',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Folder',
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