<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //$user = null;

        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
        } elseif ($request->route('username')) {
            $user = User::whereRaw('LOWER(username) = ?', [strtolower($request->route('username'))])->first();
        }

        ApiRequest::create([
            'user_id' => $user->id ?? null,
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'requested_at' => now(),
        ]);

        return $next($request);
    }
}
