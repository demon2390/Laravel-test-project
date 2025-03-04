<?php

declare(strict_types=1);

namespace App\Listeners\Users;

use App\Models\User;
use App\Notifications\Users\SendEmailVerificationNotification;

final class Registered
{
    public function handle(\Illuminate\Auth\Events\Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;

        // Create Bearer API Token for user
        $token = $user->createToken('api-auth')->plainTextToken;
        $user->setAttribute('newToken', $token);

        $user->notify(new SendEmailVerificationNotification($user));
    }
}
