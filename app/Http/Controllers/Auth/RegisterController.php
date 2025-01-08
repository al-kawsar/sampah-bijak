<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use Inertia\Inertia;


class RegisterController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }
    public function doLogin(RegisterRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!auth()->attempt($credentials))
                throw new \Exception('Email atau Password Salah!', 400);

            $request->session()->regenerate();
            return response()->json([
                'message' => 'Login Successfull'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
