<?php

namespace Indigit\Invoicing\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = config('invoicing.api-key');
        abort_unless($key, 401);
        $code = $request->bearerToken();
        abort_unless($code === $key, 403);

        return $next($request);
    }
}
