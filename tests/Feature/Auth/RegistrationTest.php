<?php

declare(strict_types=1);

test('Пользователь не может зарегистрироваться при пустом поле name', function (): void {
    $response = $this->post('/register', [
        'name' => '',
        'email' => 'email@test.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

test('Пользователь не может зарегистрироваться при пустом поле email', function (): void {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => '',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

test('Пользователь не может зарегистрироваться при пустом поле password', function (): void {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'email@test.com',
        'password' => '',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

test('Пользователь не может зарегистрироваться при пустом поле password_confirmation', function (): void {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'email@test.com',
        'password' => 'password',
        'password_confirmation' => '',
    ]);

    $response->assertStatus(422);
});

test('Пользователь может зарегистрироваться', function (): void {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'testemail@testemail.testemail',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);
});
