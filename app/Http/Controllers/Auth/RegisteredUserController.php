<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } catch (ValidationException $e) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
        }

        $user = User::query()->create([
            'name'     => $request->string('name')->trim(),
            'email'    => $request->string('email')->trim(),
            'password' => Hash::make($request->string('password')->trim()),
        ]);

        event(new Registered($user));

        return response()->json([
            'message' => 'You have been registered. Check your email.',
        ], Response::HTTP_CREATED);
    }
}
