<?php

declare(strict_types=1);

namespace App\Permissions;

class BoardMemberPermissions
{
    public const ADD_BOARD_MEMBER = [
        'name' => 'add member to board',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to add members to boards',
    ];

    public const EDIT_BOARD_MEMBER = [
        'name' => 'edit board member',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to edit board members',
    ];
    public const VIEW_BOARD_MEMBER_PROFILE = [
        'name' => 'view board member profile',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to view board member profile',
    ];

    public const REMOVE_BOARD_MEMBER = [
        'name' => 'remove board member',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to remove members from boards',
    ];


    public static function allPermissions(): array
    {
        return [
            self::ADD_BOARD_MEMBER,
            self::EDIT_BOARD_MEMBER,
            self::VIEW_BOARD_MEMBER_PROFILE,
            self::REMOVE_BOARD_MEMBER,
        ];
    }
}