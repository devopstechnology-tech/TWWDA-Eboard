<?php

declare(strict_types=1);

namespace App\Permissions;

class CommitteeMemberPermissions
{
    public const ADD_COMMITTEE_MEMBER = [
        'name' => 'add member to committee',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to add members to committees',
    ];

    public const EDIT_COMMITTEE_MEMBER = [
        'name' => 'edit committee member',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to edit committee members',
    ];
    public const VIEW_COMMITTEE_MEMBER_PROFILE = [
        'name' => 'view committee member profile',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to view committee member profile',
    ];

    public const REMOVE_COMMITTEE_MEMBER = [
        'name' => 'remove committee member',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to remove members from committees',
    ];

    public static function allPermissions(): array
    {
        return [
            self::ADD_COMMITTEE_MEMBER,
            self::EDIT_COMMITTEE_MEMBER,
            self::VIEW_COMMITTEE_MEMBER_PROFILE,
            self::REMOVE_COMMITTEE_MEMBER,
        ];
    }
}