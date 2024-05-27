<?php

declare(strict_types=1);

namespace App\Permissions;

class AssigneepollPermissions
{
    public const VIEW = [
        'name' => 'view AssigneePoll',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view AssigneePoll',
    ];

    public const CREATE = [
        'name' => 'create AssigneePoll',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create AssigneePoll',
    ];

    public const EDIT = [
        'name' => 'edit AssigneePoll',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to edit AssigneePoll',
    ];

    public const DELETE = [
        'name' => 'delete AssigneePoll',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete AssigneePoll',
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