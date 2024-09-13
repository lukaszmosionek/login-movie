<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class AuthController extends Controller
{

    private $isloginSuccess = true;
    private $system, $login, $password;

    public function login(LoginRequest $request)//: JsonResponse
    {
        $this->login = $request->input('login');
        $this->password = $request->input('password');

        $this->determineSystem();

        if($this->isloginSuccess){
            $token = $this->createJwtToken($this->login, $this->system);

            return response()->json([
                'status' => 'success',
                'token' => $token
            ]);
        }

        return response()->json([
            'status' => 'failure'
        ]);

    }

    private function determineSystem(){
        try{ //its could be moved to Services
                // Determine the company/system from the login prefix
            if ( Str::startsWith($this->login, 'FOO_') ) {

                $response = (new AuthWS())->authenticate($this->login, $this->password); // null or Exception
                $this->system = 'AuthWS';

            } elseif ( Str::startsWith($this->login, 'BAR_') ) {

                $this->isloginSuccess = (new LoginService())->login($this->login, $this->password); //1 or 0;
                $this->system = 'LoginService';

            } elseif ( Str::startsWith($this->login, 'BAZ_') ) {

                $response = (new Authenticator())->auth($this->login, $this->password); //new Success() or new Failure();
                $this->isloginSuccess = class_basename($response) == 'Success' ? true : false;
                $this->system = 'Authenticator';

            } else {

                $this->isloginSuccess = false;

            }

        }catch(\Exception $e){

            $this->isloginSuccess = false;

            Log::info( $e->getMessage() );

        }
    }

    private function createJwtToken(){
        $payload = [
            'login' => $this->login,
            'system' => $this->system
        ];

        $secretKey = config('services.jwt_secret');

        return JWT::encode($payload, $secretKey, 'HS256');
    }
}
