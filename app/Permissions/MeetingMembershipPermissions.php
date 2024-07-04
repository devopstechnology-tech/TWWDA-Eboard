<?php

declare(strict_types=1);

namespace App\Permissions;

class MeetingMembershipPermissions
{
    public const ADD_MEETING_MEMBERSHIP = [
        'name' => 'add membership to meeting',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to add memberships to meetings',
    ];

    public const EDIT_MEETING_MEMBERSHIP = [
        'name' => 'edit meeting membership',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to edit meeting memberships',
    ];
    public const VIEW_MEETING_MEMBERSHIP_PROFILE = [
        'name' => 'view meeting membership profile',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to view meeting membership profile',
    ];
    public const VIEW_MEETING_MEMBERSHIP = [
        'name' => 'view meeting memberships',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to view meeting memberships',
    ];

    public const REMOVE_MEETING_MEMBERSHIP = [
        'name' => 'remove meeting membership',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to remove memberships from meetings',
    ];

    public static function allPermissions(): array
    {
        return [
            self::ADD_MEETING_MEMBERSHIP,
            self::EDIT_MEETING_MEMBERSHIP,
            self::VIEW_MEETING_MEMBERSHIP,
            self::VIEW_MEETING_MEMBERSHIP_PROFILE,
            self::REMOVE_MEETING_MEMBERSHIP,
        ];
    }
}