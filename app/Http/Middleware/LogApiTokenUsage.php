<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiTokenUsage;
use Illuminate\Support\Facades\Auth;

class LogApiTokenUsage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
            $token = $user->currentAccessToken();

            ApiTokenUsage::create([
                'token_id' => $token->id,
                'user_id' => $user->id,
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);
        }

        return $response;
    }
}
