<?php

namespace App\Http\Resources;

use App\Helpers\SuraClassifier;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\XmlTextStructure;
use App\Helpers\XmlProcessor;
use App\Models\Translation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Commentary extends JsonResource
{
    public static function toHtml($xml, $justFlowText = false, $byVerse = false)
    {
        if (@count($xml) == 0) {
            return null;
        }
        $template = 'textParagraphs.xsl';
        if ($justFlowText) {
            $template = 'textRemoveParagraphs.xsl';
        }

        if ($byVerse) {
            $result = [];
            $texts = $xml->text;
            foreach ($texts as $text) {

                $result[] = [
                    "content" => XmlProcessor::toXml($template, null, $text->asXML()),
                    "verse_start" => (int)$text->attributes()->versstart,
                    "verse_end" => (int)$text->attributes()->versend,
                ];
            }

            return $result;
        }

        return trim(XmlProcessor::toXml($template, null, $xml->text->asXML()));
    }

    private function xmlToHTML($xml_file)
    {
        $xml = simplexml_load_file($xml_file);

        return [
            "title" => Commentary::toHtml($xml->surentitel, true),
            "author" => Commentary::toHtml($xml->autorenkurz, true),
            "sections" => $this->makeSections($xml),
        ];
    }

    private function makeSections($xml)
    {
        $sections = [
            ["anmerkung", "Anmerkungen", null, "anmerkungen", true],
            ["kommentar", "Kursorischer Kommentar", null, "kommentar", true],
            ["datierung", "Datierung", "datierungkurz", "datierung", false],
            ["literarkritik", "Literarkritik", "literarkritikkurz", "literarkritik"],
            ["aufbau", "Aufbau und Inhalt", null, "aufbauinhalt"],
            ["textkritik", "Textkritik", null, "textkritik"],
            ["komposition", "Komposition", null, "komposition"],
        ];

        $analyse = [
            [
                "entwicklungsgeschichtlicheEinordnung",
                "Entwicklungsgeschichtliche Einordnung",
                null,
                "EntwicklungsgeschichtlicheEinordnung"
            ],
            [
                "inhaltstruktur",
                "Inhalt und Struktur",
                null,
                "Inhaltstruktur"
            ],
            [
                "situativitaet",
                "Situativität und Hörererwartungen",
                null,
                "Situativität"
            ]
        ];

        $topLevelSections = collect($sections)
            ->map(fn ($entry) => $this->makeSection($xml, ...$entry))
            ->filter(fn ($entry) => $entry != null)
            ->toArray();
        if (isset($xml->analysedeutung)) {
            $analyseSections = collect($analyse)
                ->map(fn ($entry) => $this->makeSection($xml->analysedeutung, ...$entry))
                ->filter(fn ($entry) => $entry != null)
                ->toArray();

            $topLevelSections[] = [
                "id" => "analysedeutung",
                "heading" => "Analyse und Deutung",
                "sections" => $analyseSections,
            ];
        }

        return $topLevelSections;
    }

    private function makeBibliography($id)
    {
        $bibliographyNames = [
            "anmerkungen" => "anmerkung",
            "kommentar" => "kommentar",
            "literarkritik" => "literarkritik",
            "textkritik" => "textkritik",
            "entwicklungsgeschichtlicheEinordnung" => "entwicklungsgeschichte",
            "inhaltstruktur" => "inhaltstruktur",
            "situativitaet" => "situativitaet",
        ];

        if (array_key_exists($id, $bibliographyNames)) {
            $dbEntry = $this['bibliography_' . $bibliographyNames[$id]];
            if (strlen(trim($dbEntry)) == 0) {
                return null;
            }
            return XmlProcessor::toXml("bibliography.xsl", null, $dbEntry);
        }
    }

    private function makeSection($xml, $id, $generalTitle, $titleKey, $key, $isMultipleText = false)
    {

        $section = [
            "id" => $id,
            "general_title" => $generalTitle,
            "specific_title" => Commentary::toHTML($xml->{$titleKey}, true),
            "comment_title" => Translation::getOnlyGerman('commentary_title_comment_' . $id)

            #,
            # return Translation::select('de')->where('key',$key)->first()->de;
        ];

        if ($isMultipleText) {
            $verseContent = Commentary::toHtml($xml->{$key}, false, true);
            if (is_null($verseContent)) {
                return null;
            }
            $section['verse_content'] = $verseContent;
        } else {
            $content = Commentary::toHtml($xml->{$key});
            if (is_null($content)) {
                return null;
            }
            $section["content"] = $content;
        }
        $section['works_cited'] = $this->makeBibliography($id);

        return $section;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {


        $commentary_file = Storage::disk('xml_files')->path('Kommentar/' . $this->commentary_file);
        $text_structure_file = Storage::disk('xml_files')->path('Textstruktur/' . $this->text_structure_file);
        $textStructure = XmlProcessor::toXml("textStructure.xsl", $text_structure_file);
        $textStructure = XmlProcessor::XmlToJson(simplexml_load_string($textStructure));

        $suraClassifier = new SuraClassifier();
        $citation = Translation::getOnlyGerman(
            ($suraClassifier->commentaryCitationKey(
                $suraClassifier->classifySura($this->sure)
            )
            )
        );

        return array_merge(
            [
                'sura' => $this->sure,
                'text_structure' => $textStructure,
                'how_to_cite' => $citation,
            ],
            $this->xmlToHtml($commentary_file)
        );
    }
}
