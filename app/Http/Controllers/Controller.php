<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *    title="Swagger with Laravel",
 *    version="1.0.0",
 * )
 *
 * @OA\Server(url=L5_SWAGGER_CONST_HOST, description="local server"),
 *
 * @OA\SecurityScheme( securityScheme="bearerAuth", type="http", name="Authorization", in="header", scheme="bearer"),
 *
 * @OA\Get(
 *     path="/api/v1/services",
 *     operationId="getServicesList",
 *     security={{"bearerAuth":{}}},
 *     tags={"Services"},
 *     summary="Список сервисов",
 *     description="Полуение списка зарегистрированных пользователем сервисов",
 *
 *     @OA\HeaderParameter(required=true, in="header",name="Authorization", @OA\Schema(type="string", format="bearer")),
 *
 *     @OA\Response(response=200, description="Ok", @OA\JsonContent(ref="#/components/schemas/DataWrap")),
 *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError"))
 * )
 *
 * @OA\Post(
 *     path="/api/v1/services",
 *     security={{"bearerAuth":{}}},
 *     tags={"Services"},
 *     summary="Добавление сервиса",
 *     description="Добавление пользовательского сервиса в систему",
 *
 *     @OA\HeaderParameter(required=true, in="header",name="Authorization", @OA\Schema(type="string", format="bearer")),
 *
 *     @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/StoreRequestService")),
 *
 *     @OA\Response(response=202, description="Ok", @OA\JsonContent(ref="#/components/schemas/Accepted")),
 *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError")),
 *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError")),
 * )
 *
 * @OA\Get(
 *     path="/api/v1/services/{id}",
 *     security={{"bearerAuth":{}}},
 *     tags={"Services"},
 *     summary="Просмотр сервиса",
 *     description="Просмотр добавленного пользовательского сервиса",
 *
 *     @OA\HeaderParameter(required=true, in="header",name="Authorization", @OA\Schema(type="string", format="bearer")),
 *
 *     @OA\Parameter(name="id", description="Service ID", required=true, in="path", @OA\Schema(type="string")),
 *
 *     @OA\Response(response=200, description="Ok", @OA\JsonContent(ref="#/components/schemas/seviceResource")),
 *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError")),
 *     @OA\Response(response=404, description="Not Found", @OA\JsonContent(ref="#/components/schemas/NotFoundError")),
 * )
 *
 * @OA\Patch(
 *     path="/api/v1/services/{id}",
 *     security={{"bearerAuth":{}}},
 *     tags={"Services"},
 *     summary="Обновление сервиса",
 *     description="Обновление данных у добавленного пользовательского сервиса",
 *
 *     @OA\HeaderParameter(required=true, in="header",name="Authorization", @OA\Schema(type="string", format="bearer")),
 *
 *     @OA\Parameter(name="id", description="Service ID", required=true, in="path", @OA\Schema(type="string")),
 *     @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/StoreRequestService")),
 *
 *     @OA\Response(response=200, description="Ok", @OA\JsonContent(ref="#/components/schemas/seviceResource")),
 *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError")),
 *     @OA\Response(response=404, description="Not Found", @OA\JsonContent(ref="#/components/schemas/NotFoundError")),
 *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError")),
 * )
 *
 * @OA\Delete(
 *     path="/api/v1/services/{id}",
 *     security={{"bearerAuth":{}}},
 *     tags={"Services"},
 *     summary="Удаление сервиса",
 *     description="Удаление добавленного пользовательского сервиса",
 *
 *     @OA\HeaderParameter(required=true, in="header",name="Authorization", @OA\Schema(type="string", format="bearer")),
 *     @OA\Parameter(name="id", description="Service ID", required=true, in="path", @OA\Schema(type="string")),
 *
 *     @OA\Response(response=202, description="Ok", @OA\JsonContent(ref="#/components/schemas/Accepted")),
 *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError")),
 *     @OA\Response(response=404, description="Not Found", @OA\JsonContent(ref="#/components/schemas/NotFoundError")),
 * )
 *
 * @OA\Components(
 *
 *      @OA\Schema(
 *          schema="DataWrap",
 *
 *          @OA\Property(property="data", type="array",
 *
 *              @OA\Items(ref="#/components/schemas/seviceResource"),
 *          ),
 *
 *          @OA\Property(property="links", type="object",
 *             @OA\Property(property="first", type="string", nullable=true, example="string|null"),
 *             @OA\Property(property="last", type="string", nullable=true, example="string|null"),
 *             @OA\Property(property="prev", type="string", nullable=true, example="string|null"),
 *             @OA\Property(property="next", type="string", nullable=true, example="string|null"),
 *          ),
 *          @OA\Property(property="meta", type="object",
 *             @OA\Property(property="path", type="string", example="http://localhost/api/v1/services"),
 *             @OA\Property(property="per_page", type="integer", example="20"),
 *             @OA\Property(property="next_cursor", type="string", nullable=true, example="string|null"),
 *             @OA\Property(property="prev_cursor", type="string", nullable=true, example="string|null"),
 *          ),
 *      ),
 *
 *     @OA\Schema(
 *          schema="seviceResource",
 *
 *          @OA\Property(property="id", type="string", example="serviceIdString"),
 *          @OA\Property(property="name", type="string", example="service name"),
 *          @OA\Property(property="url", type="url", example="http://example.domain"),
 *          @OA\Property(property="created", type="object",
 *              @OA\Property(property="human", type="string", example="Human readable format"),
 *              @OA\Property(property="string", type="string", example="ISO8601 format"),
 *              @OA\Property(property="timestamp", type="integer", example="1741075155"),
 *          ),
 *     ),
 *
 *     @OA\Schema(
 *          schema="StoreRequestService",
 *
 *          @OA\Property(property="name", description="Название сервиса", example="Test Service"),
 *          @OA\Property(property="url", description="Полный домен с протоколом", example="https://example.test"),
 *     ),
 *
 *     @OA\Schema(
 *          schema="UnauthenticatedError",
 *
 *          @OA\Property(property="message", type="string", description="Error message", example="Unauthenticated")
 *      ),
 *
 *     @OA\Schema(
 *          schema="ValidationError",
 *
 *          @OA\Property(property="message", type="string", description="Error message", example="Invalid data send. The url has already been taken in another your service OR haven`t schema")
 *      ),
 *
 *     @OA\Schema(
 *          schema="NotFoundError",
 *
 *          @OA\Property(property="message", type="string", description="Error message", example="Resource not found")
 *      ),
 *
 *     @OA\Schema(
 *          schema="Accepted",
 *
 *          @OA\Property(property="message", type="string", description="Accepted message", example="Your service will be created in the background.")
 *      )
 * )
 */
abstract class Controller {}
