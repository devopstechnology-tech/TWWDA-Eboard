<?php

declare(strict_types=1);

namespace App\Permissions;

class MinutePermissions
{
    public const VIEW = [
        'name' => 'view Minute',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Minute',
    ];

    public const CREATE = [
        'name' => 'create Minute',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create Minute',
    ];

    public const EDIT = [
        'name' => 'edit Minute',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit Minute',
    ];

    public const DELETE = [
        'name' => 'delete Minute',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Minute',
    ];
    public const APPROVE = [
        'name' => 'approve Minute',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to approve Minute',
    ];
    public const SIGN = [
        'name' => 'sign Minute',
        'type' => 'ceo',
        'description' => 'Allows a user of type `ceo` to sign Minute',
    ];
    public static function allPermissions(): array
    {
        return [
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,self::APPROVE,
self::SIGN,
        ];
    }
}