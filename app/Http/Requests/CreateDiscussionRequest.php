<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Sourcetoad\RuleHelper\RuleSet;
use Illuminate\Foundation\Http\FormRequest;

class CreateDiscussionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
            'id' => RuleSet::create()->sometimes(),
            'topic' => RuleSet::create()->required()->string(),
            'description' => RuleSet::create()->required()->string(),
            'closestatus' => RuleSet::create()->required()->string(),
            'archivestatus' => RuleSet::create()->required()->string(),
            'assigneetype' => RuleSet::create()->required()->string(),
            'assigneestatus' => RuleSet::create()->required()->string(),
            'discussionassignees' => RuleSet::create()->sometimes(),
        ];
    }
}
