<?php

declare(strict_types=1);

namespace App\Permissions;

class MembershipPermissions
{
    public const VIEW = [
        'name' => 'view Membership',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Membership',
    ];

    public const CREATE = [
        'name' => 'create Membership',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to create Membership',
    ];

    public const EDIT = [
        'name' => 'edit Membership',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Membership',
    ];

    public const DELETE = [
        'name' => 'delete Membership',
        'type' => 'chairperson',
        'description' => 'Allows a user of type `chairperson` to delete Membership',
    ];
    public static function allPermissions(): array
    {
        return [
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,        ];
    }
}