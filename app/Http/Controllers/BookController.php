<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

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

    public function download($id)
    {
        $apiBaseUrl = config('app.api_base_url');
        $token = session('api_token');

        $apiResponse = Http::withToken($token)
            ->get("$apiBaseUrl/books/download/$id");

        if ($apiResponse->status() === 302) {
            $location = $apiResponse->header('Location');
            return redirect($location);
        }

        if ($apiResponse->successful()) {
            $disposition = $apiResponse->header('Content-Disposition');
            $matches = [];
            $filename = "file.pdf";
            if (preg_match('/filename="([^"]+)"/', $disposition, $matches)) {
                $filename = $matches[1];
            }

            return Response::make(
                $apiResponse->body(),
                200,
                [
                    'Content-Type' => $apiResponse->header('Content-Type'),
                    'Content-Disposition' => $disposition ?? ('attachment; filename="' . $filename . '"'),
                    'Content-Length' => strlen($apiResponse->body()),
                ]
            );
        }

        abort(404, 'File tidak ditemukan');
    }
}
