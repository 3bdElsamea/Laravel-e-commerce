<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/register",
     *     tags={"Auth"},
     *     summary="Register new user",
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        $credentials = ['email' => $user->email, 'password' => $data['password']];

        return $this->login($credentials);
    }

    /**
     * Get a JWT via given credentials.
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (empty($credentials['email']) || empty($credentials['password'])) {
            return responseJson(null, null, 401, 'Please enter your email and password');
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return responseJson(null, null, 401, 'Invalid credentials');
        }

//        dd($token, auth('api')->user());
        return responseJson(new UserResource(auth('api')->user()), $token);
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout()
    {
        auth('api')->logout();

        return responseJson(null, null, 200, 'Successfully logged out');

    }


}
