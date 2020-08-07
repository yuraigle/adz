<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    /**
     * Get a token via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 400);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $res = DB::select("SELECT * FROM adz_user WHERE email = ?", [$email]);

        if (count($res) !== 1) {
            return response()->json(['User with specified email and password not found'], 401);
        }

        $userRow = $res[0];
        if (!Hash::check($password, $userRow->password)) {
            return response()->json(['User with specified email and password not found'], 401);
        }

        $token = Str::random(40);
        $createdAt = new \DateTime();
        $expiresAt = new \DateTime();
        $expiresAt->add(new \DateInterval("PT8H")); // plus 8 hours

        DB::insert("INSERT INTO adz_user_token (user_id, token, created_at, expires_at, ip) VALUES (?,?,?,?,?)",
            [$userRow->id, $token, $createdAt, $expiresAt, $request->ip()]);

        return response()->json([
            'access_token' => $token,
            'expires_at' => $expiresAt->getTimestamp(),
            'name' => $userRow->name,
            'role' => $userRow->role,
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user()->name);
    }
}
