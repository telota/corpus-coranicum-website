<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Utilities;

class OldManuscriptDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->ID,
            "title" => $this->Kodextitel,
            "format" => $this->Format,
            "line_count" => $this->Zeilenzahl,
            "date" => $this->Datierung,
            "extent" => $this->Umfang,
            "call_number" => $this->Signatur,
            "archive" => new ArchiveSummary($this->archive),
            "found" => $this->Fundort,
            "provenance" => $this->Herkunftsort,
            "material_condition" => $this->Materialzustand,
            "material_kind" => $this->Materialart,
            "codicology" => Utilities::stringOrNull($this->Kodikologie),
            "writing_style" => Utilities::stringOrNull($this->Schriftduktus),
            "palaeography" => Utilities::stringOrNull($this->Palaographie),
            "literature" => Utilities::stringOrNull($this->Literatur),
            "editors" => $this->Bearbeiter,
            "commentary" => Utilities::stringOrNull($this->Kommentar),
            "pages" => ManuscriptPageSummary::collection($this->pages),
            "passages" => ManuscriptPassage::collection($this->passages)
        ];
    }
}
