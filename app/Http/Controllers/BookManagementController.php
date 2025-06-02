<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookManagementController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('app.api_base_url');
    }

    public function index()
    {
        $token = session('api_token');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/books");

        if ($response->successful()) {
            $books = $response->json();
        } else {
            $books = [];
        }

        return view('manage.books', compact('books'));
    }

    public function show($id)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/books/{$id}");

        if ($response->successful()) {
            return response()->json($response->json());
        }
        return response()->json(['message' => 'Buku tidak ditemukan'], 404);
    }

    public function store(Request $request)
    {
        $token = session('api_token');

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/books", $request->all());

        if ($response->successful()) {
            return redirect()->route('manage.books')->with('success', 'Buku berhasil ditambah');
        }
        return redirect()->route('manage.books')->with('error', 'Gagal menambah buku');
    }

    public function update(Request $request, $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)->put("{$this->apiBaseUrl}/books/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('manage.books')->with('success', 'Buku berhasil diupdate');
        }
        return redirect()->route('manage.books')->with('error', 'Gagal update buku');
    }

    public function destroy($id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/books/{$id}");

        if ($response->successful()) {
            return redirect()->route('manage.books')->with('success', 'Buku berhasil dihapus');
        }
        return redirect()->route('manage.books')->with('error', 'Gagal hapus buku');
    }
}
