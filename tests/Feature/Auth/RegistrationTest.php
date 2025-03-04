<?php

test('Пользователь не может зарегистрироваться при пустом поле name', function () {
    $response = $this->post('/register', [
        'name'                  => '',
        'email'                 => 'email@test.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

test('Пользователь не может зарегистрироваться при пустом поле email', function () {
    $response = $this->post('/register', [
        'name'                  => 'Test User',
        'email'                 => '',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

test('Пользователь не может зарегистрироваться при пустом поле password', function () {
    $response = $this->post('/register', [
        'name'                  => 'Test User',
        'email'                 => 'email@test.com',
        'password'              => '',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

test('Пользователь не может зарегистрироваться при пустом поле password_confirmation', function () {
    $response = $this->post('/register', [
        'name'                  => 'Test User',
        'email'                 => 'email@test.com',
        'password'              => 'password',
        'password_confirmation' => '',
    ]);

    $response->assertStatus(422);
});

test('Пользователь может зарегистрироваться', function () {
    $response = $this->post('/register', [
        'name'                  => 'Test User',
        'email'                 => 'testemail@testemail.testemail',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);
});
