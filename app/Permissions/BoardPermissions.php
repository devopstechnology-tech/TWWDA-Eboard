<?php

declare(strict_types=1);

namespace App\Permissions;

class BoardPermissions
{
    public const CREATE = [
        'name' => 'create board',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to create boards',
    ];

    public const EDIT = [
        'name' => 'edit board',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to edit boards',
    ];
    public const VIEW = [
        'name' => 'view board',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary', 'chairperson', 'Secretary', 'Member'],
        'description' => 'Allows a user to view boards',
    ];

    public const DELETE = [
        'name' => 'delete board',
        'type' => ['system', 'admin', 'ceo', 'chairman', 'companysecretary'],
        'description' => 'Allows a user to delete boards',
    ];


    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::DELETE,
            self::VIEW,
        ];
    }
}