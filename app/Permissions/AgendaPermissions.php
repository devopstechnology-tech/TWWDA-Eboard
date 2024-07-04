<?php

declare(strict_types=1);

namespace App\Permissions;

class AgendaPermissions
{
    public const CREATE = [
        'name' => 'create agenda',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to create agendas',
    ];

    public const EDIT = [
        'name' => 'edit agenda',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to edit agendas',
    ];

    public const VIEW = [
        'name' => 'view agenda',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'observer', 'guest'],
        'description' => 'Allows a user to view agendas',
    ];

    public const DELETE = [
        'name' => 'delete agenda',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to delete agendas',
    ];

    public const ASSIGN = [
        'name' => 'assign agenda',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to assign agendas',
    ];

    public const APPROVE = [
        'name' => 'approve agenda',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to approve agendas',
    ];

    public const SAVE = [
        'name' => 'save agenda',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary'],
        'description' => 'Allows a user to save agendas',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::VIEW,
            self::DELETE,
            self::ASSIGN,
            self::APPROVE,
            self::SAVE,
        ];
    }
}