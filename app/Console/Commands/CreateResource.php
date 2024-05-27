<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateResource extends Command
{
    protected $signature = 'make:resource {name}';
    protected $description = 'Creates a new HTTP resource';

    public function handle()
    {
        $name = $this->argument('name');
        $className = "{$name}Resource";
        $path = app_path("Http/Resources/{$className}.php");

        if (file_exists($path)) {
            $this->error("{$className} already exists!");
            return;
        }

        $namespace = 'App\Http\Resources';

        $content = <<<EOT
        <?php

        declare(strict_types=1);

        namespace $namespace;

        use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
        use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

        class $className extends BaseResource
        {
            #[Format, IsDefault]
            public function base(): array
            {
                return [
                    // Base resource fields here
                ];
            }

            #[Format('short')]
            public function short(): array
            {
                return [
                    // Short resource fields here
                ];
            }
        }
        EOT;

        file_put_contents($path, $content);
        $this->info("{$className} created successfully.");
    }
}
