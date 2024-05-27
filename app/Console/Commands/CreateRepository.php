<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateRepository extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Creates an interface in Repository/Contracts and a corresponding repository.';

    public function handle()
    {
        $name = $this->argument('name');

        // Interface and Repository paths
        $interfacePath = app_path("Repository/Contracts/{$name}Interface.php");
        $repositoryPath = app_path("Repository/{$name}Repository.php");

        // Check if files already exist
        if (File::exists($interfacePath) || File::exists($repositoryPath)) {
            $this->error('Either the repository or the interface already exists!');
            return false;
        }

        // Create the Interface
        $interfaceContent = "<?php\n\nnamespace App\\Repository\\Contracts;\n\ninterface {$name}Interface\n{\n    // Define your methods here\n}\n";
        File::ensureDirectoryExists(dirname($interfacePath));
        File::put($interfacePath, $interfaceContent);

        // Create the Repository
        $repositoryContent = "<?php\n\nnamespace App\\Repository;\n\nuse App\\Repository\\BaseRepository;\nuse App\\Repository\\Contracts\\{$name}Interface;\n\nclass {$name}Repository extends BaseRepository implements {$name}Interface\n{\n    // Implement the methods\n}\n";
        File::ensureDirectoryExists(dirname($repositoryPath));
        File::put($repositoryPath, $repositoryContent);

        $this->info("Interface and repository for {$name} created successfully.");
    }
}
