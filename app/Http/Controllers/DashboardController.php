<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $apiBaseUrl = config('app.api_base_url');
        $token = session('api_token');

        $responseStats = Http::withToken($token)->get("$apiBaseUrl/dashboard");

        if ($responseStats->successful()) {
            $stats = $responseStats->json();
            return view('admin.dashboard', compact('stats'));
        } else {
            return redirect()->route('login')->with('error', 'Gagal mengambil data dashboard.');
        }
    }
}
