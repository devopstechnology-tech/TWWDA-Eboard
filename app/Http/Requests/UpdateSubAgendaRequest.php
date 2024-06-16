<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateSubAgendaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here for update
            'title' => RuleSet::create()->required()->string(),
            'agenda_id' => RuleSet::create()->required()->string(),
            'schedule_id' => RuleSet::create()->required()->string(),
            'duration' => RuleSet::create()->sometimes()->string(),
            'description' => RuleSet::create()->sometimes()->string(),
            'assignees' => RuleSet::create()->sometimes()->array(),
            'children' => RuleSet::create()->sometimes()->array(),
        ];
    }
}