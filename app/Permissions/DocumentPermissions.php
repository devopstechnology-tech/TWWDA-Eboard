<?php

declare(strict_types=1);

namespace App\Permissions;

class DocumentPermissions
{
    //CREATE
    public const UPLOAD_DOCUMENTS = [
        'name' => 'upload documents',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to upload documents',
    ];

    public const EDIT_DOCUMENTS = [
        'name' => 'edit documents',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to edit documents',
    ];
    public const VIEW_DOCUMENTS = [
        'name' => 'view documents',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'guest'],
        'description' => 'Allows a user to view documents',
    ];

    public const ANNOTATE_DOCUMENTS = [
        'name' => 'annotate documents',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to annotate documents',
    ];

    public const SIGN_DOCUMENTS = [
        'name' => 'sign documents',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to sign documents',
    ];

    public const ARCHIVE_DOCUMENTS = [
        'name' => 'archive documents',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to archive documents',
    ];
    public const DELETE_DOCUMENTS = [
        'name' => 'delete documents',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to delete documents',
    ];

    public const VISIBILITY = [
        'name' => 'manage visibility',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'guest'],
        'description' => 'Allows a user to manage document visibility',
    ];

    public const SEARCH_DOCUMENTS = [
        'name' => 'search documents',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to search and sort documents',
    ];

    public static function allPermissions(): array
    {
        return [
            self::UPLOAD_DOCUMENTS,
            self::EDIT_DOCUMENTS,
            self::VIEW_DOCUMENTS,
            self::ANNOTATE_DOCUMENTS,
            self::SIGN_DOCUMENTS,
            self::ARCHIVE_DOCUMENTS,
            self::DELETE_DOCUMENTS,
            self::VISIBILITY,
            self::SEARCH_DOCUMENTS,
        ];
    }
}