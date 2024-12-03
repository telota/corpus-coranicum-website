<?php

namespace App\Http\Controllers;

use App\Exceptions\PayloadTooLargeException;
use App\Http\Resources\SuraCollection;
use App\Http\Resources\VersesContent;
use App\Models\CairoQuran;
use App\Helpers\Verse;
use App\Helpers\Range;
use App\Http\Resources\CairoCollection;
use Illuminate\Support\Facades\Log;

class Quran extends Controller
{

    public function getVerses($language, $sura_start, $verse_start, $sura_end, $verse_end)
    {
        $ranges = [new Range(
            new Verse($sura_start, $verse_start),
            new Verse($sura_end, $verse_end)
        )];

        try {
            return VersesContent::getVerseContent($language, $ranges);
        } catch (PayloadTooLargeException $e) {
            return Response($e->getMessage(), 436);
        }
    }

    public function getSuraSummaries()
    {
        // Trying here to figure out why this function often doesn't complete
        $current_time = time();
        $suras = new SuraCollection(CairoQuran::getAllRowsForCounting());
        if(time() > $current_time + 2){
            Log::error("Sura verse count from /api/init/quran took more than 2 seconds.");
            abort(408, "Sura verse count took more than 2 seconds.");
        }
        return $suras;
    }

    public function getCairoPages()
    {
        return new CairoCollection(CairoQuran::getAllRowsForPageMapping());
    }
}
