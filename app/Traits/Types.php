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
}