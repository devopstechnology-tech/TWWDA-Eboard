<?php

declare(strict_types=1);

namespace App\Permissions;

class TaskPermissions
{
    public const CREATE = [
        'name' => 'create task',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to create tasks',
    ];

    public const EDIT = [
        'name' => 'edit task',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to edit tasks',
    ];

    public const VIEW = [
        'name' => 'view task',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to view tasks',
    ];

    public const DELETE = [
        'name' => 'delete task',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to delete tasks',
    ];

    public const ASSIGN = [
        'name' => 'assign task',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to assign tasks',
    ];

    public const CLOSE = [
        'name' => 'close task',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to close tasks',
    ];

    public const MONITOR = [
        'name' => 'monitor task',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to monitor tasks',
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
        ];
    }
}