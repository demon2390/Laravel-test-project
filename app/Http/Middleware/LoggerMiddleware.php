<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Response;

class LoggerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $auth = $request->header('Authorization', $request->header('authorization'));
        $data = [
            'path'    => $request->getPathInfo(),
            'method'  => $request->getMethod(),
            'ip'      => $request->ip(),
            'headers' => [
                'user-agent'    => $request->header('user-agent'),
                'referer'       => $request->header('referer'),
                'origin'        => $request->header('origin'),
                'x-request-id'  => $request->header('X-Request-ID', $request->header('x-request-id', 'gen_' . hexdec(uniqid()))),
                'authorization' => $auth,
            ],
        ];

        // if you want to log all the request body
        if (count($request->all()) > 0) {
            // keys to skip like password or any sensitive information
            $hiddenKeys = ['password'];

            $data['request'] = $request->except($hiddenKeys);
        }

        $data['response'] = $response->getContent();

        $log = new Logger('stack');
        $path = "logs/" . now()->year . "/" . now()->month . "/" . now()->day . "/" . ($request->ip() ?: '') . ".log";
        $log->pushHandler(new StreamHandler(storage_path($path)));
        $log->info('', $data);

        return $response;
    }
}
