<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
        ];
    }
}