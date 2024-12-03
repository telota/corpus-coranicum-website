<?php

namespace App\Http\Resources;

use App\Helpers\Verse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CairoCollection extends ResourceCollection
{


    public static function suraAndVerse($element)
    {
        return [
            "sura" => $element->sura,
            "verse" => $element->verse,
        ];
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection
            ->groupBy('Bild')
            ->map(function ($value, $key) {
                return
                    [
                        "page" => intval(substr($key, 16, 3)),
                        "range" => [
                            "start" => CairoCollection::suraAndVerse(Verse::minByVerse($value)),
                            "end" => CairoCollection::suraAndVerse(Verse::maxByVerse($value)),
                        ],

                    ];
            })
            ->values();
    }
}
