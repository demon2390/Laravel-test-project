<?php

declare(strict_types = 1);

namespace App\Http\Responses\V1;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class MessageResponses implements Responsable
{
    /**
     * @param  array<int|string,mixed>|string|null  $message
     * @param  int  $status
     */
    public function __construct(
        private array|string|null $message,
        private int $status = Response::HTTP_OK,
    ) {
    }

    public function toResponse($request): Response
    {
        return new JsonResponse(
            data: [
                'message' => $this->message,
            ],
            status: $this->status
        );
    }
}
