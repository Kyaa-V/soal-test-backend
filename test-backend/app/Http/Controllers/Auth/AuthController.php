<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ErrorHandler;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Utils\Token;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    protected $tokenService;

    public function __construct(Token $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    public function register(UserRequest $request){

        try {
            $validatedData = $request->validated();

            $hashedPassword = bcrypt($validatedData['password']);

            DB::beginTransaction();
            $data = User::create([
             ...$validatedData,
             'password' => $hashedPassword
            ]);
        
             $data->roles()->sync([3]); //set default role sebagai customer
        
             DB::commit();
        
            return response()->json([
             'message' => 'User registered successfully',
             'success' => true
             ],201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return ErrorHandler::handle($th, 'Register User failed');
        }
    }
    public function login(LoginRequest $request){

        try {
            $validatedData = $request->validated();

            $user = User::where('email', $validatedData['email'])->first();

            if(!$user){
                return response()->json([
                    'message' => 'email or password is incorrect',
                    'success' => false
                ], 401);
            }

            $hashedPassword = $user->password;

            if(!Hash::check($validatedData['password'], $hashedPassword)){
                return response()->json([
                    'message' => 'email or password is incorrect',
                    'success' =>false

                ],401);
            }

            $role = $user->roles->pluck('name')->toArray();

            Log::info('User Roles: ', $role);

            $token = $this->tokenService->createToken(['id' => $user->id,'roles' => $role, 'name' => $user->name], 15);

            $expirationMinutes = 30 * 24 * 60;
            $refreshToken = $this->tokenService->createToken([
                'id' => $user->id,
                'roles' =>  $role,
                'name' => $user->name
            ], $expirationMinutes);

            return response()->json([
                'message' => 'login successfully',
                'success' => true,
                'payload' => [
                    'data'=> null,
                    'token' => $token
                ]
            ])->cookie('refresh_token', $refreshToken, $expirationMinutes * 60);
        } catch (\Throwable $th) {
            return ErrorHandler::handle($th, 'login failed');
        }
    }
    public function logout(Request $request){

    }
    public function forgotPassword(Request $request){

    }
}
