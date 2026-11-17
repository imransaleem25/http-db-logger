<?php

namespace Imransaleem\HttpDbLogger\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LogHttpToDatabase
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('http-db-logger.log_requests', true)) {
            return $next($request);
        }

        $user = Auth::user();
        $table = config('http-db-logger.table', 'http_db_logs');

        $id = DB::table($table)->insertGetId([
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'request_type' => $request->is('api/*') ? 'api' : 'web',
            'request_body' => json_encode($request->all()),
            'ip_address' => $request->ip(),
            'created_by' => $user?->id,
            'user_role' => $user?->role ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $next($request);

        $responseBody = null;
        $shouldLogResponse = ($request->is('api/*') && config('http-db-logger.log_api_response'))
            || (! $request->is('api/*') && config('http-db-logger.log_web_response'));

        if ($shouldLogResponse) {
            $responseBody = method_exists($response, 'getContent')
                ? $response->getContent()
                : null;
        }

        DB::table($table)
            ->where('id', $id)
            ->update([
                'response_status' => $response->getStatusCode(),
                'response_body' => $responseBody,
                'updated_at' => now(),
            ]);

        return $response;
    }
}
