<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateWorkTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
            'task_id' => RuleSet::create()->string(),
            'task_assignee_id' => RuleSet::create()->string(),
            'selectedOption' => RuleSet::create()->string(),
        ];
    }
}