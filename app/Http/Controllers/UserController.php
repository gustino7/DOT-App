<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Login dengan email dan password
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => "These credentials don't match",
            ], 400);
        }

        $token = $user->createToken('login-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Success',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    /**
     * Logout dari akun menggunakan token, dan menghapus (revoke)
     * token dari database.
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout Success',
        ], 200);
    }
}
