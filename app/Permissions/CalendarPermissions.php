<?php

declare(strict_types=1);

namespace App\Permissions;

class CalendarPermissions
{
    public const VIEW_CALENDAR = [
        'name' => 'view calendar',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'observer'],
        'description' => 'Allows a user to view calendar',
    ];

    public const COLOR_CODE_MEETINGS = [
        'name' => 'color code meetings',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to color code meetings',
    ];

    public const VIEW_TASKS_DATES = [
        'name' => 'view tasks dates',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'observer'],
        'description' => 'Allows a user to view tasks dates',
    ];

    public const COLOR_CODE_TASKS = [
        'name' => 'color code tasks',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to color code tasks',
    ];

    public const VIEW_POLLS_DATES = [
        'name' => 'view polls dates',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary', 'member', 'observer'],
        'description' => 'Allows a user to view polls dates',
    ];

    public const COLOR_CODE_POLLS = [
        'name' => 'color code polls',
        'type' => ['system', 'admin', 'ceo', 'companychairman', 'companysecretary', 'chairperson', 'secretary'],
        'description' => 'Allows a user to color code polls',
    ];

    public static function allPermissions(): array
    {
        return [
            self::VIEW_CALENDAR,
            self::COLOR_CODE_MEETINGS,
            self::VIEW_TASKS_DATES,
            self::COLOR_CODE_TASKS,
            self::VIEW_POLLS_DATES,
            self::COLOR_CODE_POLLS,
        ];
    }
}