<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\ApplicationData;
use App\Data\Credentials;
use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => RuleSet::create()
                ->required()
                ->string(),
            'password' => RuleSet::create()
                ->required()
                ->string(),
            'gps_lat' => RuleSet::create()
                ->sometimes()
                ->string(),
            'gps_long' => RuleSet::create()
                ->sometimes()
                ->string(),
            'remember' => RuleSet::create()
                ->boolean(),
        ];
    }

    public function credentials(): Credentials
    {
        return new Credentials($this->email, $this->password);
    }

    public function location(): ApplicationData
    {
        return new ApplicationData($this->gps_lat ?? '', $this->gps_long ?? '');
    }

    public function remember(): bool
    {
        return $this->boolean('remember');
    }
}
