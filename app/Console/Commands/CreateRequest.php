<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:request {name} {--u|update}';
    protected $description = 'Generates a new form request class, with an optional update request.';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $shouldCreateUpdate = $this->option('update');

        $this->createRequestFile($name, 'create');
        if ($shouldCreateUpdate) {
            $this->createRequestFile($name, 'update');
        }

        $this->info('Request(s) created successfully.');
    }

    protected function createRequestFile($name, $type)
    {
        $className = ucfirst($type) . $name . 'Request';
        $path = app_path("Http/Requests/{$className}.php");
        $template = $this->getRequestTemplate($className, $type);

        if (!file_exists($path)) {
            file_put_contents($path, $template);
        }
    }

    protected function getRequestTemplate($name, $type)
    {
        $baseNamespace = 'App\Http\Requests';

        if ($type == 'create') {
            return <<<EOT
    <?php

    declare(strict_types=1);

    namespace $baseNamespace;


    use Illuminate\Foundation\Http\FormRequest;
    use Sourcetoad\RuleHelper\RuleSet;

    class {$name} extends FormRequest
    {
        public function rules(): array
        {
            return [
                // Your rules here
            ];
        }
    }
    EOT;
        } elseif ($type == 'update') {
            return <<<EOT
    <?php

    declare(strict_types=1);

    namespace $baseNamespace;


    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rules\Unique;
    use Sourcetoad\RuleHelper\RuleSet;

    class {$name} extends FormRequest
    {
        public function rules(): array
        {
            return [
                // Your rules here for update
            ];
        }
    }
    EOT;
        }
    }


}
