<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Service $service): bool
    {
        return $user->id === $service->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, Service $service): bool
    {
        return $user->id === $service->user_id;
    }

    public function delete(User $user, Service $service): bool
    {
        return $user->id === $service->user_id;
    }
}
