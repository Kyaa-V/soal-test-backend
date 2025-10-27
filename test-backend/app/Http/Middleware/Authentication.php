<?php

namespace App\Http\Middleware;

use App\Helpers\ErrorHandler;
use App\Utils\Token;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Authentication
{

    protected $tokenService;

    public function __construct(Token $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('starting proccess middleware');

        $token = $request->bearerToken();

        if($token){
            try {
                $verifyToken = $this->tokenService->verifyToken($token);
                Log::info('access token valid');

                Log::info('verifyToken' . json_encode($verifyToken));

                $authUser = [
                    'id'    => $verifyToken->id ?? null,
                    'name'  => $verifyToken->name ?? null,
                    'roles' => $verifyToken->role[0] ?? null,
                ];

                Log::info('auth user', $authUser);

                $request->attributes->set('payload', $authUser);

                Log::info('middleware passed');
                return $next($request);
            } catch (\Throwable $th) {
                Log::info('access token invalid/expired trying refresh token');
            }
        }else{
            Log::info('access token not found in request header trying refresh token use refresh token');
        }

        Log::info('trying refresh token');
        $refreshToken = $request->cookie('refresh_token');

        Log::info('refreshToken' . $refreshToken);

        if(!$refreshToken){
            return ErrorHandler::handleNotFound('your login session has expired, please login again');
        }

        try {
            $verifyToken = $this->tokenService->verifyToken($refreshToken);

            Log::info('refresh token valid');

            $authUser =[
                'id' => $verifyToken->id ?? null,
                'name' => $verifyToken->name ?? null,
                'roles' => $verifyToken->roles ?? null
            ];

            $newToken = $this->tokenService->createToken($authUser, 15);

            Log::info('auth user', $authUser);

            $request->attributes->set('payload', $authUser);
            $request->attributes->set('token', $newToken);
            Log::info('middleware passed refrefh tokwn');

            return $next($request);
        } catch (\Throwable $th) {
            Log::warning('your session has expired, please login again');
            return ErrorHandler::handleUnauthorized('your session has expired, please login again');
        }
    }

}

