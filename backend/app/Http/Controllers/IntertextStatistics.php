<?php

namespace App\Http\Controllers;

use App\Models\CairoQuran;
use App\Models\Intertext;
use App\Helpers\Verse;
use App\Helpers\VerseFunctions;
use App\Helpers\VerseParser;

//This is a work in progress to get a full account of verses convered by intertexts.
class IntertextStatistics extends Controller
{
    protected $interexts_pers_verse;

    public function CountPerVerse()
    {
        $verse_counts = CairoQuran::getVerseCounts();

        $query = Intertext::finished()->select('TextstelleKoran')->get()->toArray();

        $ranges = array_merge(...array_map(
            fn ($el) => explode(';', $el),
            array_column($query, 'TextstelleKoran')
        ));

        $parsed_ranges = array_map(fn ($r) => VerseParser::parseVerseRange($r), $ranges);

        $counter = self::initializeCounter($verse_counts);

        foreach ($parsed_ranges as $range) {

            $current_verse = $range->start;
            while (isset($current_verse) && !$current_verse->isGreaterThan($range->end)) {
                $counter[$current_verse->sura][$current_verse->verse]++;
                $current_verse = VerseFunctions::NextVerse($current_verse, $verse_counts);
            }
        }
        return $counter;
    }

    public static function initializeCounter($verse_counts)
    {
        $counter = array();
        foreach ($verse_counts as $sura => $verses) {
            $counter[$sura] = array_fill(1, $verses, 0);
        }
        return $counter;
    }
}
