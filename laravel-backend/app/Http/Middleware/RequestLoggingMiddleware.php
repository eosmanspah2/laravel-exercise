<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RequestLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->logRequest($request);

        return $next($request);
    }

    /**
     * Log the incoming request.
     *
     * @param  Request  $request
     * @return void
     */
    protected function logRequest(Request $request)
    {
        Log::info('Incoming Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'query_params' => $request->query(),
            'request_params' => $request->all(),
        ]);
    }
}
