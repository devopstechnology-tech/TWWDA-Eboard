<?php

declare(strict_types=1);

namespace App\Permissions;

class MeetingPermissions
{
    public const CREATE = [
        'name' => 'create meeting',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to create meetings',
    ];

    public const EDIT = [
        'name' => 'edit meeting',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to edit meetings',
    ];

    public const VIEW = [
        'name' => 'view meeting',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'guest'],
        'description' => 'Allows a user to view meetings',
    ];

    public const DELETE = [
        'name' => 'delete meeting',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to delete meetings',
    ];

    public const CONFIRM = [
        'name' => 'confirm meeting',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to confirm meetings',
    ];

    public const PUBLISH = [
        'name' => 'publish meeting',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to publish meetings',
    ];
    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::VIEW,
            self::DELETE,
            self::CONFIRM,
            self::PUBLISH,
        ];
    }
}