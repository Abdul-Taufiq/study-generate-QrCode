<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $data = 1;
        if ($data === 1) {
            # code...
            return $next($request);
        } else {
            abort(207, 'Tidak ada akses');
        }
    }
}
