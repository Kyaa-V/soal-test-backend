<?php

namespace App\Http\Middleware;

use App\Helpers\ErrorHandler;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class authRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $payload = $request->attributes->get('payload_user');

        if(!$payload){
            return ErrorHandler::handleNotFound('your login session has expired, please login again');
        }
        $roles = $payload['roles'] ?? [];

        if(in_array('ADMIN', $roles)){
            Log::info('user has ADMIN role, access grated');
            return $next($request);
        }

        return ErrorHandler::handleForbidden('you do not have permission to access this resource');

    }
}
