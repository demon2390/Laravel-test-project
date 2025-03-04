<?php

declare(strict_types=1);

use App\Models\User;
use App\Notifications\Users\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

beforeEach(function (): void {
    Notification::fake();

    $email = 'testemail2@testemail2.testemail';

    $this->post('/register', [
        'name' => 'Test User',
        'email' => $email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->user = User::query()->firstWhere('email', $email);
});

test('Электронное письмо отправляется для подтверждения email', function (): void {
    Notification::assertSentTo($this->user, SendEmailVerificationNotification::class);
});

test('Пользователь может верифицировать email', function (): void {
    expect($this->user->id === null)->toBeFalse();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
    );

    $response = $this
        ->actingAs($this->user)
        ->get($verificationUrl);

    expect($this->user->refresh()->hasVerifiedEmail())->toBeTrue();

    $response->assertStatus(201);
});

test('Пользователь не может верифицировать email из-за неправильного хеша', function (): void {
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1('wrong-email')]
    );

    $response = $this->actingAs($this->user)->get($verificationUrl);

    $response->assertStatus(406);

    expect($this->user->fresh()->hasVerifiedEmail())->toBeFalse();
});
