<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

final class RegisteredUserController
{
    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Users"},
     *     summary="Регистрация пользователя",
     *     description="Добавление пользователя в систему с последующей отправкой почты с Bearer токеном",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="password"),
     *             @OA\Property(property="password_confirmation", type="string", example="password")
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
        } catch (ValidationException $e) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
        }

        $user = User::query()->create([
            'name' => $request->string('name')->trim(),
            'email' => $request->string('email')->trim(),
            'password' => Hash::make($request->string('password')->trim()->value()),
        ]);

        event(new Registered($user));

        return response()->json([
            'message' => 'You have been registered. Check your email.',
        ], Response::HTTP_CREATED);
    }
}
