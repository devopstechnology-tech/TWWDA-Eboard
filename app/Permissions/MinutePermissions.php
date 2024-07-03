<?php

declare(strict_types=1);

namespace App\Permissions;

class MinutePermissions
{
    public const CREATE = [
        'name' => 'create minutes',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to create minutes',
    ];

    public const EDIT = [
        'name' => 'edit minutes',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to edit minutes',
    ];

    public const VIEW = [
        'name' => 'view minutes',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'guest'],
        'description' => 'Allows a user to view minutes',
    ];

    public const SEND_APPROVAL = [
        'name' => 'send approve minutes',
        'type' => ['system', 'admin', 'ceo', 'companysecretary'],
        'description' => 'Allows a user to send minutes for approval minutes',
    ];

    public const APPROVE = [
        'name' => 'approve minutes',
        'type' => ['system', 'admin', 'ceo', 'companysecretary'],
        'description' => 'Allows a user to approve minutes',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::VIEW,
            self::SEND_APPROVAL,
            self::APPROVE,
        ];
    }
}