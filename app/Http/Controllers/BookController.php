<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function userHome(Request $request)
    {
        $apiBaseUrl = config('app.api_base_url');
        $token = session('api_token');

        $response = Http::withToken($token)
            ->get("$apiBaseUrl/books");

        if ($response->successful()) {
            $books = $response->json();
            return view('home', compact('books'));
        } else {
            return redirect()->route('login')->with('error', 'Gagal mengambil data buku.');
        }
    }
}
