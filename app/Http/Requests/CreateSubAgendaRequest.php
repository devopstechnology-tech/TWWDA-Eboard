<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateSubAgendaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
            'title' => RuleSet::create()->required()->string(),
            'meeting_id' => RuleSet::create()->required()->string(),
            'agenda_id' => RuleSet::create()->sometimes()->string(),
        ];
    }
}
