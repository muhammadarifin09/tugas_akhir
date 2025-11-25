<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SkipNgrokWarning
{
    public function handle(Request $request, Closure $next)
    {
        // Set header pada REQUEST agar ngrok melewati halaman warning
        $request->headers->set('ngrok-skip-browser-warning', 'true');

        return $next($request);
    }
}
