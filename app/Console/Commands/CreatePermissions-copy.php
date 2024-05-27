<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreatePermissions extends Command
{
    // Updated command signature to take four positional arguments for flags
    protected $signature = 'make:permissions {model} {viewFlag=a} {createFlag=a} {editFlag=a} {deleteFlag=s}';

    protected $description = 'Generate permissions classes for a specified model with simplified flag inputs';

    public function handle()
    {
        $modelName = $this->argument('model');
        $modelClassName = ucfirst(strtolower($modelName)) . 'Permissions';

        // No need to prepend flags with '-', just take them directly as they are
        $viewFlag = $this->argument('viewFlag');
        $createFlag = $this->argument('createFlag');
        $editFlag = $this->argument('editFlag');
        $deleteFlag = $this->argument('deleteFlag');

        $viewType = $this->getTypeFromFlag($viewFlag);
        $createType = $this->getTypeFromFlag($createFlag);
        $editType = $this->getTypeFromFlag($editFlag);
        $deleteType = $this->getTypeFromFlag($deleteFlag);

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

    public static function allPermissions(): array
    {
        return [
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,
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
        return match($flag) {
            'd' => 'default',
            'a' => 'admin',
            's' => 'system',
            default => 'admin'
        };
    }
}
