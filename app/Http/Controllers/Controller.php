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
 * @OA\Server(url="http://localhost", description="local server"),
 *
 * @OA\SecurityScheme( securityScheme="bearerAuth", type="http", name="Authorization", in="header", scheme="bearer"),
 *
 * @OA\Get(
 *     path="/api/v1/services",
 *     security={{"bearerAuth":{}}},
 *     tags={"Services"},
 *     summary="Список сервисов",
 *     description="Полуение списка зарегистрированных пользователем сервисов",
 *
 *     @OA\HeaderParameter(required=true, in="header",name="Authorization", @OA\Schema(type="string", format="bearer")),
 *
 *     @OA\Response(response=200, description="Ok", @OA\JsonContent(ref="#/components/schemas/DataWrap")),
 *     @OA\Response(response=401, description="Unauthenticated")
 * )
 *
 * @OA\Components(
 *
 *      @OA\Schema(
 *          schema="DataWrap",
 *
 *          @OA\Property(property="data", type="array",
 *
 *              @OA\Items(
 *
 *                  @OA\Property(property="id", type="string", example="serviceIdString"),
 *                  @OA\Property(property="name", type="string", example="service name"),
 *                  @OA\Property(property="url", type="url", example="http://example.domain"),
 *                  @OA\Property(property="created", type="object",
 *                      @OA\Property(property="human", type="string", example="8 hours ago"),
 *                      @OA\Property(property="string", type="string", example="2025-03-04T07:59:15+00:00"),
 *                      @OA\Property(property="timestamp", type="integer", example="1741075155"),
 *                  ),
 *              ),
 *          ),
 *          @OA\Property(property="links", type="object",
 *             @OA\Property(property="first", type="string", nullable=true),
 *             @OA\Property(property="last", type="string", nullable=true),
 *             @OA\Property(property="prev", type="string", nullable=true),
 *             @OA\Property(property="next", type="string", nullable=true),
 *          ),
 *          @OA\Property(property="meta", type="object",
 *             @OA\Property(property="path", type="string", example="http://localhost/api/v1/services"),
 *             @OA\Property(property="per_page", type="integer"),
 *             @OA\Property(property="next_cursor", type="string", nullable=true),
 *             @OA\Property(property="prev_cursor", type="string", nullable=true),
 *          ),
 *      )
 * )
 */
abstract class Controller {}
