<?php

namespace App\Http\Resources;

use App\Http\Resources\VerseRange;
use Illuminate\Http\Resources\Json\JsonResource;

class IntertextSummary extends JsonResource 
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->ID,
            'title' => $this->Titel,
            'entry_author' => $this->Bearbeiter,
            'language' => $this->Sprache,
            'location' => $this->Ort,
            'dated' => $this->Datierung,
            'source' => $this->Edition,
            'intertext_author' => $this->Autor,
            'category' => $this->category,
            'supercategory' => $this->supercategory,
            'range' => new VerseRange($this),
        ];
    }
}
