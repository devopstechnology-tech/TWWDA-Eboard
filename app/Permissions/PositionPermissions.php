<?php

declare(strict_types=1);

namespace App\Permissions;

class PositionPermissions
{
    public const CREATE = [
        'name' => 'create position',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to create positions',
    ];

    public const UPDATE = [
        'name' => 'update position',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to update positions',
    ];

    public const VIEW = [
        'name' => 'view position',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to view positions',
    ];

    public const DELETE = [
        'name' => 'delete position',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to delete positions',
    ];
    public const ASSIGN_BOARD_POSITION = [
        'name' => 'assign board position',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to assign positions in board',
    ];
    public const ASSIGN_COMMITTEE_POSITION = [
        'name' => 'assign committee position',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to assign position in committee',
    ];
    public const ASSIGN_MEETING_POSITION = [
        'name' => 'assign meeting position',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to assign positions in meeting',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::UPDATE,
            self::VIEW,
            self::DELETE,
            self::ASSIGN_BOARD_POSITION,
            self::ASSIGN_COMMITTEE_POSITION,
            self::ASSIGN_MEETING_POSITION,
        ];
    }
}
