<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SuraCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->reduce(
            function ($suras, $row) {
                $sura = $row->sure;
                if (!isset($suras[$sura - 1])) {
                    $suras[$sura - 1] = [
                        'verses' => 0,
                        'key' => $sura,
                        'nameTranslit' => '',
                    ];
                }
                if ($row->surenname !== null) {
                    $suras[$sura - 1]['nameTranslit'] = $row->surenname;
                }
                if ($row->vers != 0) {
                    $suras[$sura - 1]['verses']++;
                }

                return $suras;
            },
            []
        );
    }
}
