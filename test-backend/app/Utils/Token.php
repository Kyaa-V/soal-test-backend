<?php

namespace App\Utils;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token{

    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = env('JWT_SECRET_TOKEN');
    }
    public static function generateToken($length = 32){
        return bin2hex(random_bytes($length / 2));
    }

    public static function validateToken($token){
        return preg_match('/^[a-f0-9]{32}$/', $token) === 1;
    }

    public function createToken($payload, $expiration = 60){

        $issuedAt = time();
        $expired = $issuedAt + ( $expiration * 60);

        $payload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $expired
        ]);

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function verifyToken($token){
        try {
            return JWT::decode($token, new Key($this->secretKey,'HS256'));
        } catch (Exception $th) {
           throw new Exception('Invalid Token', $th->getMessage());
        }
    }
}