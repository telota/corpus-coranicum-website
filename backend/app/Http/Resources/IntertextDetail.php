<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Utilities;
use App\Models\Commentary;
use App\Models\Intertext;
use App\Models\IntertextMapping;
use App\Models\IntertextImage as ImageModel;
use App\Http\Resources\IntertextImage as ImageResource;
use App\Http\Resources\VerseRange;

class IntertextDetail extends JsonResource
{
    public function intertextTranslations()
    {
        $languages = array("dt", "en", "fr", "ar");

        $translations = array();

        foreach ($languages as $language) {
            $translation = $this->{"Uebersetzung_" . $language};

            //Would of course be better to change the database row name to de
            if ($language == "dt") {
                $language = "de";
            }
            $translations[$language] = Utilities::stringOrNull($translation);
        }

        return $translations;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $id = $this->ID;
        return [
            'id' => $this->ID,
            'title' => $this->Titel,
            'language' => $this->Sprache,
            'location' => $this->Ort,
            'dated' => $this->Datierung,
            'source' => $this->Edition,
            'intertext_author' => $this->Autor,
            'translation_source' => $this->Uebersetzung,
            'identified_by' => $this->Identifikator,
            'notes' => $this->Anmerkungen,
            'entry_author' => $this->Bearbeiter,
            'first_published' => Utilities::stringOrNull($this->Einstelldatum),
            'updated_at' => $this->updated_at,
            'content' => Utilities::stringOrNull(urldecode($this->Originalsprache)),
            'content_direction' => $this->Sprache_richtung,
            'transcription' => Utilities::stringOrNull($this->Transkription),
            'translations' => $this->intertextTranslations(),
            'literature' => Utilities::stringOrNull($this->Literatur),
            'category' => $this->category,
            'supercategory' => $this->supercategory,
            'images' => ImageResource::collection(ImageModel::fetchForIntertext($id)),
            'passages' => VerseRange::collection(IntertextMapping::byIntertextId($id)->get()),
            'sura_commentaries' => $this->mentionedInCommentaries->pluck('sure'),
        ];
    }
}
