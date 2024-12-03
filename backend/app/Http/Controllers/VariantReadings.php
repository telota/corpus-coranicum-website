<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variant;
use App\Http\Resources\VariantReadingCollection as VRResource;
use App\Models\CairoQuran;
use App\Models\Quran;
use App\Models\VariantReader;
use App\Models\VariantSource;
use App\Helpers\Utilities;

class VariantReadings extends Controller
{
    //
    public function getVariantsByVerse($sura, $verse)
    {


        $variants = Variant::fetchVariants($sura, $verse);
        $sources = $variants->pluck('source_id')->unique();
        $roles = VariantSource::with(['citations.author', 'citations.role'])
            ->whereIn("id", $sources)
            ->orderByRaw('length(todesdatum),todesdatum' )
            ->get();
        $rolesCleaned = $roles->map(function ($r) {
            return [
                "source" => $r->anzeigetitel,
                "contributors" => $r->citations->map(function ($c) {
                    return [
                        "name" => $c->author->author_name,
                        "role" => $c->role->role_name,
                    ];
                })->sortBy('name')->values(),
            ];
        });

        return [
            'variant_readings' => new VRResource($variants),
            'reference' => Quran::getVerse($sura, $verse)
                ->keyBy('word')
                ->map(function ($item) {
                    return collect($item)->forget('word');
                }),
            'commentary' => Utilities::stringOrNull(CairoQuran::getReadingVariantsCommentary($sura, $verse)->commentary),
            'citations' => $rolesCleaned,
        ];
    }

    public function canonicalReaders()
    {
        return [
            'work' => VariantSource::getCanonicalSource(),
            'readers' => VariantReader::getCanonicalReaders(),
        ];
    }
}
