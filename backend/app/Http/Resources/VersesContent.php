<?php

namespace App\Http\Resources;

use App\Exceptions\PayloadTooLarge;
use App\Exceptions\PayloadTooLargeException;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Quran;
use App\Models\QuranTranslation;
use Illuminate\Support\Facades\DB;

/*Note: this is not an extenson of a JsonResource 
between throwing and catching custom errors in a JsonResource does not work.
*/

class VersesContent
{
    public static function getVerseContent($language, $verseRanges)
    {
        if(sizeof($verseRanges) == 0){
            return [];
        }
        $query = Quran::where('vers', '>', 0);
        Quran::queryOverRanges($query, $verseRanges);
        $wordCount = $query->count();
        $wordLimit = 1000;
        if ($wordCount > $wordLimit) {
            throw new PayloadTooLargeException("word_limit_of_" . $wordLimit . "_exceeded");
        }

        $translations = QuranTranslation::getVerses(
            $language,
            $verseRanges,
        );

        $original = Quran::getVerses($verseRanges);
        foreach ($original as $verse) {
            $translation = $translations->first(function ($value) use ($verse) {
                return $value->sura == $verse->sura && $value->verse == $verse->verse;
            });

            if (isset($translation)) {
                $verse->translation = $translation->text;
            }
            $verse->arabic = implode(" ", explode(",", $verse->arabic));
            $verse->transcription = implode(" ", explode(",", $verse->transcription));
        }
        return $original;
    }
}
