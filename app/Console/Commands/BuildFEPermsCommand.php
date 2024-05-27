<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BuildFEPermsCommand extends Command
{
    protected const COMMON_OUTPUT_PATH = 'front/common/perms';
    protected const CUSTOMER_OUTPUT_PATH = 'front/customer/enums';
    protected const STAFF_OUTPUT_PATH = 'front/staff/enums';
    protected $signature = 'build:fe-perms {enum?} {--check} {--preview}';
    protected $description = 'Builds the FE perms based on the PHP permissions.';

    public function handle(): void
    {
        $path = app_path().'/Permissions';
        $paths = $this->getAllPermissions($path);
        $outputFile = resource_path(sprintf('%s/%s.ts', BuildFEPermsCommand::COMMON_OUTPUT_PATH, 'all-permissions'));
        //        collect($paths)->each(function ($permission) {
        //            Permission::firstOrCreate([
        //                ...$permission,
        //                'guard_name' => 'web',
        //            ]);
        //        });
        $lines = collect([
            '// !!! This is a generated file. Do not change this file manually.',
            '',
            //            sprintf('const %s = {', 'permissions'),
            ...Permission::get()->map(function ($permission) {
                return sprintf(
                    "export const %s = '%s';",
                    'STAFF_PERMISSION_'.Str::replace(
                        [' ', '::'],
                        '_',
                        Str::upper($permission->name)
                    ),
                    $permission->name
                );
            })->toArray(),
            //            '} as const;',
            //            '',
            //            sprintf('type %1$s = typeof %1$s[keyof typeof %1$s];', 'test'),
            //            '',
            //            sprintf('export default %s;', 'test'),
            //            '',
        ]);
        //        dd($lines);
        $this->components->twoColumnDetail('test', $outputFile);
        file_put_contents($outputFile, $lines->join("\n"));
    }

    public function getAllPermissions($path): array
    {
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') {
                continue;
            }
            $filename = $path.'/'.$result;
            if (is_dir($filename)) {
                $out = array_merge($out, $this->getAllPermissions($filename));
            } else {
                $class = substr('App\\Permissions\\'.$result, 0, -4);
                foreach (range(1, count((new $class())::allPermissions())) as $index) {
                    $out[] = [
                        ...(new $class())::allPermissions()[$index - 1],
                        'class' => explode('.', $result)[0],
                        'action' => ucfirst(explode(' ', (new $class())::allPermissions()[$index - 1]['name'])[0]),
                    ];
                }
            }
        }

        return $out;
    }
}
