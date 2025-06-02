<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $apiUrl = config('app.api_base_url') . '/login';

        try {
            $response = Http::post($apiUrl, [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $data = $response->json();

            if ($response->successful() && isset($data['token'])) {
                session(['api_token' => $data['token'], 'user_role' => $data['user']['role']]);

                $redirectUrl = match ($data['user']['role']) {
                    'admin' => route('admin.dashboard'),
                    'petugas' => route('manage.books'),
                    default => route('user.home'),
                };

                return response()->json([
                    'success' => true,
                    'redirect_url' => $redirectUrl,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'Login gagal',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}
