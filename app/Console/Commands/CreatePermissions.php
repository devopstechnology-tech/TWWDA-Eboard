<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreatePermissions extends Command
{
    protected $signature = 'make:permissions {model} {viewFlag=o} {createFlag=s} {editFlag=a} {deleteFlag=s} {approveFlag?} {signFlag?}';
    protected $description = 'Generate permissions classes for a specified model with simplified flag inputs';

    public function handle()
    {
        $modelName = $this->argument('model');
        $modelClassName = ucfirst(strtolower($modelName)) . 'Permissions';

        $viewFlag = $this->argument('viewFlag');
        $createFlag = $this->argument('createFlag');
        $editFlag = $this->argument('editFlag');
        $deleteFlag = $this->argument('deleteFlag');
        $approveFlag = $this->argument('approveFlag');
        $signFlag = $this->argument('signFlag');

        $viewType = $this->getTypeFromFlag($viewFlag);
        $createType = $this->getTypeFromFlag($createFlag);
        $editType = $this->getTypeFromFlag($editFlag);
        $deleteType = $this->getTypeFromFlag($deleteFlag);
        $approveType = $approveFlag ? $this->getTypeFromFlag($approveFlag) : null;
        $signType = $signFlag ? $this->getTypeFromFlag($signFlag) : null;

        $template = <<<PHP
<?php

declare(strict_types=1);

namespace App\Permissions;

class $modelClassName
{
    public const VIEW = [
        'name' => 'view $modelName',
        'type' => '$viewType',
        'description' => 'Allows a user of type `$viewType` to view $modelName',
    ];

    public const CREATE = [
        'name' => 'create $modelName',
        'type' => '$createType',
        'description' => 'Allows a user of type `$createType` to create $modelName',
    ];

    public const EDIT = [
        'name' => 'edit $modelName',
        'type' => '$editType',
        'description' => 'Allows a user of type `$editType` to edit $modelName',
    ];

    public const DELETE = [
        'name' => 'delete $modelName',
        'type' => '$deleteType',
        'description' => 'Allows a user of type `$deleteType` to delete $modelName',
    ];

PHP;

        if ($approveType) {
            $template .= <<<PHP
    public const APPROVE = [
        'name' => 'approve $modelName',
        'type' => '$approveType',
        'description' => 'Allows a user of type `$approveType` to approve $modelName',
    ];

PHP;
        }

        if ($signType) {
            $template .= <<<PHP
    public const SIGN = [
        'name' => 'sign $modelName',
        'type' => '$signType',
        'description' => 'Allows a user of type `$signType` to sign $modelName',
    ];

PHP;
        }

        $template .= <<<PHP
    public static function allPermissions(): array
    {
        return [
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,
PHP;

        if ($approveType) {
            $template .= "self::APPROVE,\n";
        }

        if ($signType) {
            $template .= "self::SIGN,\n";
        }

        $template .= <<<PHP
        ];
    }
}
PHP;

        $filePath = app_path("Permissions/{$modelClassName}.php");
        file_put_contents($filePath, $template);
        $this->info("Permissions class for $modelName created at $filePath");
    }

    protected function getTypeFromFlag($flag)
    {
        return match ($flag) {
            's' => 'system',
            'a' => 'admin',
            'c' => 'ceo',
            'h' => 'companychairman',
            'k' => 'companysecretary',
            'p' => 'chairperson',
            't' => 'secretary',
            'm' => 'member',
            'g' => 'guest',
            'o' => 'observer',
            default => 'observer',
        };
    }
}



// Setting: Create and delete by system, edit by admin, view by all.
// ActivityLog: View by all, created automatically.
// Permission: Create and delete by system, edit by admin, view by all.
// Role: Create by company secretary, delete by system, edit by admin, view by all.
// User: Create, edit, and delete by system, edit by admin, view by all.
// Profile: Create and delete by company secretary, edit by all, view by all.
// Board: Create and delete by company chairman, edit by all, view by all.
// Member: Create and delete by company secretary, edit by all, view by all.
// Committee: Create and delete by company secretary, edit by all, view by all.
// Folder: Create by member and delete by system, edit by all, view by all.
// Membership: Create and delete by chairperson, edit by all, view by all.
// Agenda: Create and delete by chairperson, edit by all, view by all.
// SubAgenda: Create and delete by chairperson, edit by all, view by all.
// Discussion: Create by member, edit by all, view by all, delete by system.
// Meeting: Create and edit by chairperson, view by member, delete by system.
// Conflict: Create and edit by member, view by member, delete by system.
// Media: Create and edit by member, view by member, delete by system.
// Minute: Create and edit by secretary, view by member, delete by system, approve and sign by chairperson or CEO.
// DetailMinute: Create and edit by secretary, view by member, delete by system.
// SubDetailMinute: Create and edit by secretary, view by member, delete by system.
// MinuteReview: Create and edit by secretary, view by member, delete by system.
// Poll: Create and edit by secretary, approve by chairperson, delete by system, view by member.
// AssigneePoll: Create and edit by secretary and chairperson, delete by system, view by member.
// Option: Create and edit by secretary, approve by chairperson, delete by system, view by member.
// Schedule: Create and edit by secretary, delete by system, view by member.
// Task: Create and edit by secretary, delete by system, view by member.
// AssigneeTask: Create and edit by secretary, delete by system, view by member.
// Modification: Create and edit by company secretary, delete by system, view by member.
// Almanac: Create and edit by company secretary, delete by system, view by member.
// Notification: Create and edit by company secretary, delete by system, view by member.

// capture al lthe return match ($flag) {
//     's' => 'system',
//     'a' => 'admin',
//     'c' => 'ceo',
//     'h' => 'companychairman',
//     'k' => 'companysecretary',
//     'p' => 'chairperson',
//     't' => 'secretary',
//     'm' => 'member',
//     'g' => 'guest',
//     'o' => 'observer',
//     default => 'observer', be creatve ther the hierachy starts from top and is a board managmentment syste,m be creative and senure everythignis captured and als where to approve you can not like the  minute, meetng, amanac files singin as wellSetting: Create and delete by system, edit by admin, view by all.
// ActivityLog: View by all, created automatically.
// Permission: Create and delete by system, edit by admin, view by all.
// Role: Create by company secretary, delete by system, edit by admin, view by all.
// User: Create, edit, and delete by system, edit by admin, view by all.
// Profile: Create and delete by company secretary, edit by all, view by all.
// Board: Create and delete by company chairman, edit by all, view by all.
// Member: Create and delete by company secretary, edit by all, view by all.
// Committee: Create and delete by company secretary, edit by all, view by all.
// Folder: Create by member and delete by system, edit by all, view by all.
// Membership: Create and delete by chairperson, edit by all, view by all.
// Agenda: Create and delete by chairperson, edit by all, view by all.
// SubAgenda: Create and delete by chairperson, edit by all, view by all.
// Discussion: Create by member, edit by all, view by all, delete by system.
// Meeting: Create and edit by chairperson, view by member, delete by system.
// Conflict: Create and edit by member, view by member, delete by system.
// Media: Create and edit by member, view by member, delete by system.
// Minute: Create and edit by secretary, view by member, delete by system, approve and sign by chairperson or CEO.
// DetailMinute: Create and edit by secretary, view by member, delete by system.
// SubDetailMinute: Create and edit by secretary, view by member, delete by system.
// MinuteReview: Create and edit by secretary, view by member, delete by system.
// Poll: Create and edit by secretary, approve by chairperson, delete by system, view by member.
// AssigneePoll: Create and edit by secretary and chairperson, delete by system, view by member.
// Option: Create and edit by secretary, approve by chairperson, delete by system, view by member.
// Schedule: Create and edit by secretary, delete by system, view by member.
// Task: Create and edit by secretary, delete by system, view by member.
// AssigneeTask: Create and edit by secretary, delete by system, view by member.
// Modification: Create and edit by company secretary, delete by system, view by member.
// Almanac: Create and edit by company secretary, delete by system, view by member.
// Notification: Create and edit by company secretary, delete by system, view by member.

// php artisan make:permissions Setting o s a s
// php artisan make:permissions Permission o s a s
// php artisan make:permissions Role o k a s
// php artisan make:permissions User o s a s
// php artisan make:permissions Profile o k a k
// php artisan make:permissions Board o h a h
// php artisan make:permissions Member o k a k
// php artisan make:permissions Committee o k a k
// php artisan make:permissions Folder o m a s
// php artisan make:permissions Membership o p a p
// php artisan make:permissions Agenda o p a p
// php artisan make:permissions SubAgenda o p a p
// php artisan make:permissions Discussion o m a s
// php artisan make:permissions Meeting m p p s
// php artisan make:permissions Conflict m m m s
// php artisan make:permissions Media m m m s
// php artisan make:permissions Minute m t t s p c
// php artisan make:permissions DetailMinute m t t s
// php artisan make:permissions SubDetailMinute m t t s
// php artisan make:permissions MinuteReview m t t s
// php artisan make:permissions Poll m t t s p
// php artisan make:permissions AssigneePoll m t p s
// php artisan make:permissions Option m t t s p
// php artisan make:permissions Schedule m t t s
// php artisan make:permissions Task m t t s
// php artisan make:permissions AssigneeTask m t t s
// php artisan make:permissions Modification m k k s
// php artisan make:permissions Almanac m k k s
// php artisan make:permissions Notification m k k s