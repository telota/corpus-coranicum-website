<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\VariantReader;
use App\Models\VariantSource;
use App\Helpers\Utilities;

class VariantReadingCollection extends ResourceCollection
{
    public function toSource($sources)
    {
        assert(sizeof($sources) === 1);
        $source = [];
        foreach (VariantSource::$sourceFields as $field) {
            $source[$field[1]] = $sources[0]['source_' . $field[1]];
        }

        // Only ad-Dani is canonical for present purposes.
        if ($source['id'] !== 16){
            $source['canonical'] = 0;
        }

        return $source;

    }

    public function toWord($item)
    {
        return $item[0]->variant;
    }

    public function toReader($item)
    {
        $reader = [];

        foreach (VariantReader::$readerFields as $field) {
            $reader[($field[1])] = $item[('reader_' . $field[1])];
        }

        return $reader;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {

        return $this->collection
            ->groupBy('reading_id')
            ->map(function ($reading) {
                return [
                    'reading_id' => $reading[0]->reading_id,
                    'reading_commentary' => Utilities::stringOrNull($reading[0]->reading_commentary),
                    'readers' => $reading->unique('reader_id')->map([$this, 'toReader'])->values(),
                    'variants' => $reading->groupBy('word')->collect()->map([$this, 'toWord']),
                    'work' => $this->toSource($reading->unique('source_id')),
                ];
            });
    }
}
