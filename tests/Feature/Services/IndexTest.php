<?php

declare(strict_types=1);

use App\Models\Service;
use App\Models\User;

use function Pest\Laravel\actingAs;

use Symfony\Component\HttpFoundation\Response;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->user->token = $this->user->createToken('api-token')->plainTextToken;

    $this->jsonStructureService = [
        'data' => [
            [
                'id',
                'name',
                'url',
                'created' => ['human', 'string', 'timestamp'],
            ],
        ],
        'links' => ['first', 'last', 'prev', 'next'],
        'meta' => ['path', 'per_page', 'next_cursor', 'prev_cursor'],
    ];
});

test('Неавторизованный пользователь получает корректный статус код', function (): void {
    actingAs($this->user)
        ->getJson(
            uri: action('App\Http\Controllers\Api\V1\ServiceController@index')
        )->assertStatus(Response::HTTP_UNAUTHORIZED);
});

test('Авторизованный пользователь получает корректный статус код', function (): void {
    actingAs($this->user)
        ->withToken($this->user->token)
        ->getJson(
            uri: action('App\Http\Controllers\Api\V1\ServiceController@index')
        )->assertStatus(Response::HTTP_OK);
});

test('Авторизованный пользователь не может создать новый сервис из-за некорректного URL', function (): void {
    actingAs($this->user)
        ->withToken($this->user->token)
        ->post('api/v1/services', [
            'name' => 'Test service name',
            'url' => 'example.domain.test',
        ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

test('Авторизованный пользователь может создать новый сервис', function (): void {
    actingAs($this->user)
        ->withToken($this->user->token)
        ->post('api/v1/services', [
            'name' => 'Test service name',
            'url' => 'http://example.domain.test',
        ])
        ->assertStatus(Response::HTTP_ACCEPTED);
});

test('Авторизованный пользователь видит только свои данные', function (): void {
    Service::factory()->for($this->user)->count(2)->create();
    Service::factory()->count(5)->create();

    actingAs($this->user)
        ->withToken($this->user->token)
        ->getJson(
            uri: action('App\Http\Controllers\Api\V1\ServiceController@index')
        )
        ->assertStatus(Response::HTTP_OK)
//        ->assertJsonCount(3)
        ->assertJsonCount(2, 'data');
});

test('Ответ приходит в ожидаемом формате и структура ответа должна соответствовать ожиданиям API дизайна', function (): void {
    Service::factory()->for($this->user)->count(2)->create();

    actingAs($this->user)
        ->withToken($this->user->token)
        ->getJson(
            uri: action('App\Http\Controllers\Api\V1\ServiceController@index')
        )
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure($this->jsonStructureService);
});

test('Ответ пагинирован', function (): void {
    Service::factory()->for($this->user)->count(2)->create();

    actingAs($this->user)
        ->withToken($this->user->token)
        ->getJson(
            uri: action('App\Http\Controllers\Api\V1\ServiceController@index')
        )
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure($this->jsonStructureService);
});

todo('Пользователь может подключить в ответ связанные доп. данные');

todo('Пользователь может фильтровать свой запрос для получения специфического ответа');

todo('Пользователь может сортировать результат при передаче порядка сортировки');
