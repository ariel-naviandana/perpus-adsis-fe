<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
    {
        // Split roles dengan tanda '-'
        $rolesArray = explode('-', $roles);
        // Ambil role dari session FE, bukan dari $request->user()
        $userRole = session('user_role');

        if (!$userRole || !in_array($userRole, $rolesArray)) {
            // Untuk web, lebih baik redirect ke login, bukan response JSON
            return redirect()->route('login');
        }

        return $next($request);
    }
}
