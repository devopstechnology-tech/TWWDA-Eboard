<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'meeting_id' => RuleSet::create()->sometimes(),
            'board_id' => RuleSet::create()->sometimes(),
            'committee_id' => RuleSet::create()->sometimes(),
            'title' => RuleSet::create()->required()->string(),
            'duedate' => RuleSet::create()->required()->string(),
            'description' => RuleSet::create()->required()->string(),
            'status' => RuleSet::create()->required()->string(),
            'assigneetype' => RuleSet::create()->required()->string(),
            'assigneestatus' => RuleSet::create()->required()->string(),
            'taskassignees' => RuleSet::create()->sometimes(),
        ];
    }
}
