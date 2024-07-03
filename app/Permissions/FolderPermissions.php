<?php

declare(strict_types=1);

namespace App\Permissions;

class FolderPermissions
{
    public const CREATE_FOLDERS = [
        'name' => 'create folders',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to create folders',
    ];
    public const CREATE_DROPZONE = [
        'name' => 'create dropzone',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to create a dropzone for document uploads',
    ];
    public const EDIT_FOLDERS = [
        'name' => 'edit folders',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to edit folders',
    ];
    public const VIEW_FOLDERS = [
        'name' => 'view folders',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'guest'],
        'description' => 'Allows a user to view folders',
    ];
    public const DELETE_FOLDERS = [
        'name' => 'delete folders',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to delete folders',
    ];


    public static function allPermissions(): array
    {
        return [
            self::CREATE_FOLDERS,
            self::CREATE_DROPZONE,
            self::EDIT_FOLDERS,
            self::VIEW_FOLDERS,
            self::DELETE_FOLDERS,
        ];
    }
}