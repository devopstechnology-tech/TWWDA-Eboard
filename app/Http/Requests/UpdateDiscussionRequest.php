<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Sourcetoad\RuleHelper\RuleSet;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscussionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
            'id' => RuleSet::create()->required()->string(),
            'topic' => RuleSet::create()->required()->string(),
            'description' => RuleSet::create()->required()->string(),
            'closestatus' => RuleSet::create()->required()->string(),
            'archivestatus' => RuleSet::create()->required()->string(),
            'discussionassignees' => RuleSet::create()->sometimes(),
        ];
    }
}
