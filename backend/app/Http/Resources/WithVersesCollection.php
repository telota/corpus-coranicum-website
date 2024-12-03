<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Helpers\Verse;

class WithVersesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $intertexts = $this->collection
            ->groupBy('id')
            ->map(function($idGroup){
                return Verse::minByVerse($idGroup);
            });
        return $intertexts;
    }
}
