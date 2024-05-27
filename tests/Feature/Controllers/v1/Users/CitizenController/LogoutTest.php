<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\v1\Users\CitizenController;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testLogoutWhenUnauthenticated(): void
    {
        // Arrange
        // Nothing to arrange.

        // Act
        $response = $this->performAction(null);
        // Assert
        $this->assertGuest();
        $response->assertUnauthorized();
    }

    private function performAction($token): TestResponse
    {
        return $this->withHeader('Authorization', 'Bearer '.$token)->postJson(route('citizen.logout'));
    }

    public function testLogoutWhenAuthenticated(): void
    {
        // Arrange
        $user = $this->actAsCitizen();
        // Act
        $response = $this->performAction($user['data']['token']);
        // Assert
        $response->assertNoContent();
    }
}
