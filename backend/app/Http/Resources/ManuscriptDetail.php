<?php

namespace App\Http\Resources;

use App\Helpers\Utilities;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\ZoteroToBibliography;

class ManuscriptDetail extends JsonResource
{

    public function minLine(?string $lines): ?string
    {
        $parsed = $this->splitLineCount($lines);
        return $parsed ? $parsed[0] : null;
    }

    public function maxLine(?string $lines): ?string
    {
        $parsed = $this->splitLineCount($lines);
        return $parsed ? $parsed[1] : null;
    }

    public function splitLineCount(?string $lines): ?array
    {
        if (!isset($lines)) {
            return null;
        }

        $parsed = explode(' - ', $lines);

        if (sizeof($parsed) == 2) {
            return $parsed;
        }

        return null;
    }

    public function getCiteThisPageString()
    {

        $title = $this->archive->place_name . ": " . $this->call_number;

        $metadata = $this->authorRoles
            ->filter(fn($entry) => $entry->role->role_name == 'metadata' && $entry->role->module->module_name == 'manuscript')
            ->pluck('author.author_name')
            ->sortBy(fn($n) => collect(explode(" ", $n))->last())
            ->implode('/');

        $transliteration = $this->authorRoles
            ->filter(fn($entry) => $entry->role->role_name == 'transliteration' && $entry->role->module->module_name == 'manuscript')
            ->pluck('author.author_name')
            ->sortBy(fn($n) => collect(explode(" ", $n))->last())
            ->implode(', ');

        $assistance = $this->authorRoles
            ->filter(fn($entry) => $entry->role->role_name == 'assistance' && $entry->role->module->module_name == 'manuscript')
            ->pluck('author.author_name')
            ->sortBy(fn($n) => collect(explode(" ", $n))->last());

        if (sizeof($assistance) == 0) {
            $assistanceString = "";

        } else {
            if (sizeof($assistance) == 1) {
                $assistanceList = $assistance[0];
            } else {
                $assistanceList = $assistance->slice(0, -1)->implode(", ");
                $assistanceList = $assistanceList . " and " . $assistance->last();

            }
            $assistanceString = " (with assistance from $assistanceList)";

        }

        $transliterationString = strlen($transliteration) > 0 ? ", transliteration: " . $transliteration : "";
//        dd($assistance);
        $citeThisPage = "$metadata$assistanceString, \"$title\"$transliterationString, in: " .
            "Manuscripta Coranica, published by Berlin-Brandenburgische Akademie der Wissenschaften, edited by Michael Marx.";


        return $citeThisPage;
    }


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->date_start && ($this->date_start === $this->date_end)) {
            $date = strval($this->date_start);
        } elseif ($this->date_start && $this->date_end) {
            $date = $this->date_start . " - " . $this->date_end;
        } else {
            $date = $this->date_start . $this->date_end;
        }

        return [
            'id' => $this->id,
            'call_number' => $this->call_number,
            'dimensions' => $this->dimensions,
            'format_text_field' => $this->format_text_field,
            'date' => $date,
            'archive' => new ArchiveSummary($this->archive),
            'line_min' => $this->minLine($this->number_of_lines),
            'line_max' => $this->maxLine($this->number_of_lines),
            'number_of_folios' => $this->number_of_folios,
            'carbon_dating' => $this->carbon_dating,
            'provenances' => $this->provenances->pluck('provenance'),
            'writing_surface' => $this->writing_surface,
            'codicology' => $this->codicology,
            'paleography' => $this->paleography,
            'script_styles' => $this->script_styles->pluck('style'),
            "citation" => $this->getCiteThisPageString(),
            "catalogue_entry" => $this->catalogue_entry,
            "bibliography" => ZoteroToBibliography::pickZoteroEntries($this->catalogue_entry . $this->codicology . $this->paleography),
            'pages' => ManuscriptPageSummary::collection($this->pages),
            "passages" => ManuscriptPassage::collection($this->passages)

        ];
    }
}
