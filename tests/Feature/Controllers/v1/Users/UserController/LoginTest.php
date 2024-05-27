<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\v1\Users\UserController;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public static function validationProvider(): array
    {
        return [
            'id_number is required' => [
                'payload' => [],
                'expectedErrors' => [
                    'id_number' => 'The id number field is required.',
                ],
            ],
            'id_number must be a string' => [
                'payload' => [
                    'id_number' => 321,
                ],
                'expectedErrors' => [
                    'id_number' => 'The id number must be a string',
                ],
            ],
            'password is required' => [
                'payload' => [],
                'expectedErrors' => [
                    'password' => 'The password field is required.',
                ],
            ],
            'password must be a string' => [
                'payload' => [
                    'password' => 123,
                ],
                'expectedErrors' => [
                    'password' => 'The password must be a string.',
                ],
            ],
            'remember must be boolean' => [
                'payload' => [
                    'remember' => 'not-a-valid-boolean',
                ],
                'expectedErrors' => [
                    'remember' => 'The remember field must be true or false.',
                ],
            ],
        ];
    }

    /** @dataProvider validationProvider */
    public function testLoginValidation(array $payload, array $expectedErrors): void
    {
        // Arrange
        // Nothing to arrange.
        // Act
        $response = $this->performAction($payload);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors($expectedErrors);
    }

    private function performAction(array $payload): TestResponse
    {
        return $this->postJson(route('web.login'), $payload);
    }

    public function testAuthenticateWithInvalidCredentials(): void
    {
        // Arrange
        $user = User::withoutApproval()->factory()
            ->password('rr')
            ->createOne();

        // Act
        $response = $this->performAction([
            'id_number' => $user->id_number,
            'password' => 'password',
        ]);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            '_' => 'These credentials do not match our records.',
        ]);
    }

    public function testAuthenticateWithValidCredentials(): void
    {
        // Arrange
        $user = User::withoutApproval()->factory()
            ->password('password')
            ->createOne();

        // Act
        $response = $this->performAction([
            'id_number' => $user->id_number,
            'password' => 'password',
        ]);

        // Assert
        //        $this->assertAuthenticatedAs($user);
        $response->assertOk();
        //        $response->assertJson(UserResource::make($user)->login($response['data']['token'])->format(UserResource::LOGIN)->toJsonAssertion());
    }
}
