<?php

declare(strict_types=1);

namespace App\Permissions;

class AlmanacPermissions
{
    public const CREATE = [
        'name' => 'create almanac',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to create almanacs',
    ];

    public const EDIT = [
        'name' => 'edit almanac',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to edit almanacs',
    ];

    public const UPLOAD = [
        'name' => 'upload almanac',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to upload almanacs',
    ];

    public const PUBLISH = [
        'name' => 'publish almanac',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to publish almanacs',
    ];
    public const POSTPONE = [
        'name' => 'postpone almanac',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to postpone almanacs',
    ];
    public const MAKRHELD = [
        'name' => 'mark held almanac',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to mark held almanacs',
    ];
    public const CANCEL = [
        'name' => 'cancel almanac',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to cancel almanacs',
    ];
    public const VIEW = [
        'name' => 'view almanac',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'observer'],
        'description' => 'Allows a user to view almanacs',
    ];
    public const DELETE = [
        'name' => 'delete almanac',
        'type' => ['system', 'admin', 'companysecretary'],
        'description' => 'Allows a user to delete almanacs',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::UPLOAD,
            self::PUBLISH,
            self::POSTPONE,
            self::MAKRHELD,
            self::CANCEL,
            self::VIEW,
            self::DELETE,
        ];
    }
}