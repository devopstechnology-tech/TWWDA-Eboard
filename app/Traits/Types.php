<?php

declare(strict_types=1);

namespace App\Traits;

trait Types
{
    public static string $type_system            = 'system';
    public static string $type_admin             = 'admin';
    public static string $type_ceo               = 'ceo';
    public static string $type_company_chairman  = 'companychairman';
    public static string $type_company_secretary = 'companysecretary';
    public static string $type_chairperson       = 'chairperson';
    public static string $type_secretary         = 'secretary';
    public static string $type_member            = 'member';
    public static string $type_guest             = 'guest';
    public static string $type_default           = 'observer';

    public static function allTypes(): array
    {
        return [
            self::$type_system,
            self::$type_admin,
            self::$type_ceo,
            self::$type_company_chairman,
            self::$type_company_secretary,
            self::$type_chairperson,
            self::$type_secretary,
            self::$type_member,
            self::$type_guest,
            self::$type_default,
        ];
    }

    public static function mapRoleToType(string $roleName): string
    {
        // Mapping of role names to type constants, all keys are in lowercase
        $mapping = [
            'system'            => self::$type_system,
            'admin'             => self::$type_admin,
            'ceo'               => self::$type_ceo,
            'company chairman'  => self::$type_company_chairman,
            'company secretary' => self::$type_company_secretary,
            'chairperson'       => self::$type_chairperson,
            'secretary'         => self::$type_secretary,
            'member'            => self::$type_member,
            'guest'             => self::$type_guest,
            'observer'          => self::$type_default,
        ];

        // Convert the input role name to lowercase to ensure case insensitivity
        $normalizedRoleName = strtolower($roleName);

        // Return the type value for the normalized role name or the default value if not found
        return $mapping[$normalizedRoleName] ?? self::$type_default;
    }
}