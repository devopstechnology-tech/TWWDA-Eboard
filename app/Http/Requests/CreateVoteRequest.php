<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateVoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
            'poll_id' => RuleSet::create()->string(),
            'poll_assignee_id' => RuleSet::create()->string(),
            'selectedOption' => RuleSet::create()->string(),
        ];
    }
}