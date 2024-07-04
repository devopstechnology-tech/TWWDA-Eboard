<?php

declare(strict_types=1);

namespace App\Permissions;

class NotificationPermissions
{
    public const RECEIVE = [
        'name' => 'receive notifications',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to receive notifications on system updates and email',
    ];

    public const MEETING_CREATION = [
        'name' => 'meeting creation notification',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to receive notifications on meeting creation',
    ];

    public const MEETING_CANCELATION = [
        'name' => 'meeting cancellation notification',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to receive notifications on meeting cancellation',
    ];

    public const DOCUMENT_SHARED = [
        'name' => 'document shared notification',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to receive notifications on document sharing',
    ];

    public const REQUESTED_SIGNATURES = [
        'name' => 'requested signatures notification',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to receive notifications on requested signatures',
    ];

    public const GROUP_ADDITION = [
        'name' => 'group addition notification',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to receive notifications on group addition',
    ];

    public const GROUP_REMOVAL = [
        'name' => 'group removal notification',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to receive notifications on group removal',
    ];

    public const DISCUSSION_CREATED = [
        'name' => 'discussion created notification',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member'],
        'description' => 'Allows a user to receive notifications on discussion creation',
    ];

    public static function allPermissions(): array
    {
        return [
            self::RECEIVE,
            self::MEETING_CREATION,
            self::MEETING_CANCELATION,
            self::DOCUMENT_SHARED,
            self::REQUESTED_SIGNATURES,
            self::GROUP_ADDITION,
            self::GROUP_REMOVAL,
            self::DISCUSSION_CREATED,
        ];
    }
}