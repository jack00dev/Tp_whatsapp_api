<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function tokenLogin()
    {
        return [
            "message" => "Authentification requise pour avoir un token valide.",
        ];
    }

    public function register(Request $request)
    {

        try {
            $request->validate([
                'name' => "required",
                'email' => "required|email|unique:users",
                'phone_number' => "required|unique:users",
                'password' => "required|min:6",
            ]);

            $user = User::create($request->all());
            $token = $user->createToken($user->id)->plainTextToken;

            Auth::login($user);

            return [
                'user' => $user,
                'token' => $token,
            ];
        } catch (ValidationException $err) {
            return [
                'message' => "Données non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => "required",
                'password' => "required|min:6",
            ]);

            $user = User::where("email", $request->email)->first();

            if (!$user)
                return response()->json([], 400);

            if (!Hash::check($request->password, $user->password))
                return response()->json([], 400);


            $user->tokens()->delete();
            Auth::login($user);

            $token = $user->createToken($user->id)->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (ValidationException $err) {
            return [
                'message' => "Données non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();

            $user->tokens()->delete();
            Auth::logout();

            return [
                'message' => "Déconnexion réussie.",
            ];
        } catch (ValidationException $err) {
        } catch (\Throwable $th) {
            return [
                'message' => "Déconnexion réussie.",
            ];
        }
    }
}
