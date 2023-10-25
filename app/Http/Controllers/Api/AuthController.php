<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'login' => 'required|string|max:100',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (!Auth::attempt([$field => $request->login, 'password' => $request->password])) {
            return response()->json([
                'status' => false,
                'errors' => ['Usuario, correo o contraseña invalidas.'],
            ], 401);
        }

        $user = User::where($field, $request->login)->first();

        return response()->json([
            'status' => true,
            'message' => 'Usuario Logueado',
            'data' => $user,
            'token' => $user->createToken('API TOKEN')->plainTextToken,
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([

            'status' => true,
            'message' => 'Haz cerrado sesion',

        ], 200);
    }

}
