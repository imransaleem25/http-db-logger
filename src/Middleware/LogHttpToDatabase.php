<?php

namespace Imransaleem\HttpDbLogger\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogHttpToDatabase
{
    public function handle($request, Closure $next)
    {
        if (config('http-db-logger.log_requests', true)) {

            $user = Auth::check() ? Auth::user() : null;
            $table = config('http-db-logger.table', 'http_logs');
            $id = DB::table($table)->insertGetId([
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'request_type' => $request->is('api/*') ? 'api' : 'web',
                'request_body' => json_encode($request->all()),
                'ip_address' => $request->ip(),
                'created_by' => optional($user)->id,
                'user_role' => optional($user)->role ?? null,  // Or use $user?->role->name
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $response = $next($request);

            $responseBody = null;
            if (($request->is('api/*') && config('log_api_response')) ||
                (!$request->is('api/*') && config('log_web_response')) ) {

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
        } else {
            $response = $next($request);
        }

        return $response;
    }
}

