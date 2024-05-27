<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreatePollRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
            'meeting_id' => RuleSet::create()->sometimes(),
            'board_id' => RuleSet::create()->sometimes(),
            'committee_id' => RuleSet::create()->sometimes(),
            'question' => RuleSet::create()->required()->string(),
            'description' => RuleSet::create()->required()->string(),
            'questionoptiontype' => RuleSet::create()->required()->string(),
            'optionstatus' => RuleSet::create()->required()->string(),
            'options' => RuleSet::create()->required()->array(),
            'duedate' => RuleSet::create()->required()->string(),
            'assigneetype' => RuleSet::create()->required()->string(),
            'assigneestatus' => RuleSet::create()->required()->string(),
            'pollassignees' => RuleSet::create()->sometimes(),
            'status' => RuleSet::create()->required()->string(),
        ];
    }
}
