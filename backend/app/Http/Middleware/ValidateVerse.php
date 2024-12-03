<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\CairoQuran;
use App\Models\QuranConcordance;

class ValidateVerse
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
        $sura = Utility::getUrlVariable($request, 'sura');
        $verse = Utility::getUrlVariable($request, 'verse');
        $word = Utility::getUrlVariable($request, 'word');

        if (($sura) && ($verse) && ($word)) {
            if (is_numeric($sura) && is_numeric($verse) && is_numeric($word)) {
                if (
                    QuranConcordance::where([
                        ['sure_cc', '=', $sura],
                        ['vers_cc', '=', $verse],
                        ['wort_cc', '=', $word]
                    ])
                    ->count() == 0
                ) {
                    return response('Word does not exist.', 404);
                }
            } else {
                return response('Sura, Verse or Word is not numeric.', 404);
            }
        }
        else if (($sura) && ($verse)) {
            if (is_numeric($sura) && is_numeric($verse)) {
                if (
                    CairoQuran::where([
                        ['sure', '=', $sura],
                        ['vers', '=', $verse]
                    ])
                    ->count() == 0
                ) {
                    return response('Verse does not exist.', 404);
                }
            } else {
                return response('Sura or Verse is not numeric.', 404);
            }
        }
        return $next($request);
    }
}
