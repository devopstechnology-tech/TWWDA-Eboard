<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateImportAlmanacRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fileupload' => Ruleset::create()
                ->required()->file()
                ->mimes(
                    'csv',
                ),
        ];
    }
}