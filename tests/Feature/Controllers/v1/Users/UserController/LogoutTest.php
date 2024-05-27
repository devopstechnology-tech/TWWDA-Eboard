<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\v1\Users\UserController;

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
        return $this->withHeader('Authorization', 'Bearer '.$token)->postJson(route('web.logout'));
    }

    public function testLogoutWhenAuthenticated(): void
    {
        // Arrange
        $user = $this->actAsUser();
        // Act
        $response = $this->performAction($user['data']['token']);
        // Assert
        $response->assertNoContent();
    }
}
