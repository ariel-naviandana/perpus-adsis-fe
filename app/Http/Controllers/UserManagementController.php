<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserManagementController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('app.api_base_url');
    }

    public function index()
    {
        $token = session('api_token');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/users");

        if ($response->successful()) {
            $users = $response->json();
        } else {
            $users = [];
        }

        return view('manage.users', compact('users'));
    }

    public function store(Request $request)
    {
        $token = session('api_token');

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/users", $request->all());

        if ($response->successful()) {
            return redirect()->route('manage.users')->with('success', 'User berhasil ditambah');
        }
        return redirect()->route('manage.users')->with('error', 'Gagal menambah user');
    }

    public function update(Request $request, $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)->put("{$this->apiBaseUrl}/users/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('manage.users')->with('success', 'User berhasil diupdate');
        }
        return redirect()->route('manage.users')->with('error', 'Gagal update user');
    }

    public function destroy($id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/users/{$id}");

        if ($response->successful()) {
            return redirect()->route('manage.users')->with('success', 'User berhasil dihapus');
        }
        return redirect()->route('manage.users')->with('error', 'Gagal hapus user');
    }
}
