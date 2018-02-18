<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class HttpsProtocol
{
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('APP_ENV') === 'prod') {
            $url = url()->current();
            $url = str_replace_first("http://", "https://", $url);
            return redirect()->secure($url);
        }

        return $next($request);
    }
}