<?php

declare(strict_types=1);

namespace App\Permissions;

class DiscussionPermissions
{
    public const CREATE = [
        'name' => 'create discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to create discussions',
    ];

    public const EDIT = [
        'name' => 'edit discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to edit discussions',
    ];

    public const ADD_GROUP = [
        'name' => 'add group to discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to add groups to discussions',
    ];

    public const ADD_INDIVIDUALS = [
        'name' => 'add individuals to discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to add individuals to discussions',
    ];
    public const VIEW = [
        'name' => 'view discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to view discussions',
    ];
    public const DELETE = [
        'name' => 'delete discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to delete discussions',
    ];
    public const LEAVE = [
        'name' => 'leave discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to leave discussions',
    ];
    public const COPY_LINK = [
        'name' => 'copy link discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to copy link  discussions',
    ];
    public const MARK_READ = [
        'name' => 'mark read discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to mark read  discussions',
    ];
    public const CLOSE = [
        'name' => 'close discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to close  discussions',
    ];
    public const ARCHIVE = [
        'name' => 'archive discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to archive  discussions',
    ];
    public const PRINT = [
        'name' => 'print discussion',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to print  discussions',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::ADD_GROUP,
            self::ADD_INDIVIDUALS,
            self::VIEW,
            self::DELETE,
            self::LEAVE,
            self::COPY_LINK,
            self::MARK_READ,
            self::CLOSE,
            self::ARCHIVE,
            self::PRINT,
        ];
    }
}