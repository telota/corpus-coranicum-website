<?php

namespace App\Http\Resources;

use App\Exceptions\PayloadTooLargeException;
use App\Helpers\Verse;
use App\Helpers\Range;
use App\Models\Manuscript;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use DOMDocument;
use XSLTProcessor;

class ManuscriptPageDetail extends JsonResource
{

    private function makeRanges()
    {
        return $this->passages
            ->filter(function ($passage) {
                return
                    isset($passage->sura_start)
                    && isset($passage->verse_start)
                    && isset($passage->sura_end)
                    && isset($passage->verse_end);
            })
            ->map(function ($passage) {
                //Note: $passage->resolve() would allow us to access
                // ->start->sura, etc.
                return new Range(
                    new Verse($passage->sura_start, $passage->verse_start),
                    new Verse($passage->sura_end, $passage->verse_end)
                );
            })->toArray();
    }

    //This is an ugly function mostly copied from legacy code.
    //Since we want to switch over to the MET Transliteration tool anyway, we'll leave the mess.
    private static function getTransliteration($transliteration_file, $folio, $side)
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($transliteration_file);
        //     # xml data correct loaded?
        if (false !== $xml) {
            $xpath_pb = '//pb[@xml:id="f.' . $folio . $side . '"]';
            $afterPb = array();
            $pbResult = $xml->xpath($xpath_pb);
            if (!empty($pbResult)) {
                $pb = $pbResult[0];
                $afterPb = $pb->xpath('./following-sibling::*');
            }
            $page =
                "<page>";
            foreach ($afterPb as $elem) {
                if ($elem->getName() == 'pb') {
                    break;
                }
                $page .= $elem->asXML();
            }
            $page .= "</page>";
            $transliteration = new SimpleXMLElement($page);
            $xsldoc = new DOMDocument();
            $xsl = new XSLTProcessor();
            # url('xsl/transliteration.xsl')
            $xsldoc->load(resource_path('xsl/transliteration.xsl'));
            libxml_use_internal_errors(true);
            $result = $xsl->importStyleSheet($xsldoc);
            if (!$result) {
                //     foreach (libxml_get_errors() as $error) {
                //         echo "Libxml error: {$error->message}\n";
                //     }
                return '';
            } else {
                return $xsl->transformToXML($transliteration);
            }
            libxml_use_internal_errors(false);
        }
        return null;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        try {
            $verses = VersesContent::getVerseContent($request->language, $this->makeRanges());
        } catch (PayloadTooLargeException $e) {
            $verses = $e->getMessage();
        }

        $transliteration_file = $this->manuscript->transliteration_file;
        if ($transliteration_file) {
            $path = Storage::disk('xml_files')
                ->path('Manuskript/' . $transliteration_file);
            $transliteration = ManuscriptPageDetail::getTransliteration(
                $path,
                $this->folio,
                $this->page_side,
            );
        }

        return [
            'manuscript_id' => $this->manuscript->id,
            'page_id' => $this->id,
            'folio' => $this->folio,
            'side' => $this->page_side,
            "passages" => ManuscriptPassage::collection($this->passages),
            'images' => new ManuscriptImageCollection($this->images, true),
            'transliteration' => $transliteration ?? null,
            'verses' => $verses,
        ];
    }
}
