<?php

declare(strict_types=1);

namespace App\Permissions;

class PollPermissions
{
    public const CREATE = [
        'name' => 'create poll',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to create polls',
    ];

    public const EDIT = [
        'name' => 'edit poll',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to edit polls',
    ];

    public const VIEW = [
        'name' => 'view poll',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to view polls',
    ];

    public const DELETE = [
        'name' => 'delete poll',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to delete polls',
    ];

    public const ASSIGN = [
        'name' => 'assign poll',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to assign polls',
    ];

    public const CLOSE = [
        'name' => 'close poll',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to close polls',
    ];

    public const MONITOR = [
        'name' => 'monitor poll',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to monitor polls',
    ];

    public const PRIVACY = [
        'name' => 'poll privacy',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to manage poll privacy',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::VIEW,
            self::DELETE,
            self::ASSIGN,
            self::CLOSE,
            self::MONITOR,
            self::PRIVACY,
        ];
    }
}