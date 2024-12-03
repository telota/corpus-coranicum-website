<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $language = Utility::getUrlVariable($request, 'language');

        if ($language && !in_array($language, config('cc_config.languages'))) {
            return response('Language not supported.', 404);
        }

        return $next($request);
    }
}
