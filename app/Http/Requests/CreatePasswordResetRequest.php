<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Sourcetoad\RuleHelper\RuleSet;
use Illuminate\Foundation\Http\FormRequest;

class CreatePasswordResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => RuleSet::create()
                ->required()
                ->email()
                ->exists(User::class, 'email')  // Checks if the email exists in the 'users' table
                ->string(),
        ];
    }
}
