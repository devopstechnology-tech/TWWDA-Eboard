<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use App\Models\Users\Citizen;
use App\Models\Users\Staff;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;
    use DatabaseMigrations;

    public const BASE = 'api/v1';

    public const TOKEN = 'some-random-token';

    protected static function fullLink($link): string
    {
        return config('app.namespace').'/'.self::BASE.$link;
    }

    protected static function makeUser(string $role = 'Super Admin', string $type = 'default')
    {
        $user = User::factory()->make(['id' => Str::uuid()]);
        $user->assignRole($role, $type);
        Auth::login($user);

        return $user;
    }

    protected static function allowAuthorization(User $user): void
    {
        Http::fake([
            env('AUTH_SERVICE_URL').'/*' => Http::response(['data' => $user, 'message' => 'Certain message'], 200),
        ]);

        Http::assertNothingSent();
    }

    public function actAsUser(): TestResponse
    {
        $user = User::withoutApproval()->factory()->password('@Passwor0d')->createOne();

        return $this->loginAs(route('web.login'), $user->id_number, '@Passwor0d');
    }

    protected function loginAs($link, $id_number, $password): TestResponse
    {
        return $this->postJson($link, [
            'id_number' => $id_number,
            'password' => $password,
        ]);

        //        return json_decode($response->getContent());
    }

    public function actAsCitizen(): TestResponse
    {
        $user = Citizen::factory()->password('@Passwor0d')->createOne();

        return $this->loginAs(route('citizen.login'), $user->id_number, '@Passwor0d');
    }

    public function actAsStaff(): TestResponse
    {
        $user = Staff::withoutApproval()->factory()->password('@Passwor0d')->createOne();

        return $this->loginAs(route('pos.login'), $user->id_number, '@Passwor0d');
    }

    protected function muteMail(): void
    {
        Mail::fake();
        Mail::assertNothingQueued();
    }

    protected function muteEvent(): void
    {
        Event::fake();
        Event::assertNothingDispatched();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(
            ThrottleRequests::class
        );
    }
}
