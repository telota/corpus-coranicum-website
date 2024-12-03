<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Verse;
use App\Helpers\Range;

class VerseRange extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return new Range(
            new Verse($this->sure_start, $this->vers_start),
            new Verse($this->sure_ende, $this->vers_ende),
        );
    }
}