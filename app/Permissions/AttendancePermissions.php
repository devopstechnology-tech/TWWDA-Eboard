<?php

declare(strict_types=1);

namespace App\Permissions;

class AttendancePermissions
{
    public const ADD_REMOVE_MEMBERS = [
        'name' => 'add remove members',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to add and remove members',
    ];
    public const VIEW_ATTENDANCE = [
        'name' => 'view attendances',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'guest'],
        'description' => 'Allows a user to view attendances',
    ];

    public const SEND_ATTENDANCE = [
        'name' => 'send attendance',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to send attendance',
    ];

    public const SIGN_ATTENDANCE = [
        'name' => 'sign attendance',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to sign attendance',
    ];

    public static function allPermissions(): array
    {
        return [
            self::ADD_REMOVE_MEMBERS,
            self::VIEW_ATTENDANCE,
            self::SEND_ATTENDANCE,
            self::SIGN_ATTENDANCE,
        ];
    }
}