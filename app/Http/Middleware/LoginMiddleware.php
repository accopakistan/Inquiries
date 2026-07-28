<?php
namespace App\Http\Middleware;

use Closure;

class LoginMiddleware
{
    public function handle($request, \Closure $next)
    {
        if (!session('logged_in')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
