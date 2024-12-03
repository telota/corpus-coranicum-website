<?php

namespace App\Http\Controllers;

use App\Models\Commentary as CommentaryModel;
use App\Http\Resources\Commentary as CommentaryResource;
use App\Http\Resources\SuraId;
use App\Helpers\XmlProcessor;
use App\Helpers\SuraClassifier;
use App\Models\Translation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Commentary extends Controller
{
    public function getCommentary($sura)
    {
        return new CommentaryResource((CommentaryModel::fetchSura($sura)));
    }

    public function availableCommentaries()
    {
        return SuraId::collection((CommentaryModel::availableSuras()));
    }

    public function getIntroduction($name)
    {
        if ($name == "late-middle-mecca") {
            $commentary = CommentaryModel::findOrFail(115);
        } else {
            $commentary = CommentaryModel::findOrFail(0);

        }
        $file = Storage::disk('xml_files')->path('Kommentar/' . $commentary->commentary_file);

        $content = XmlProcessor::toXml("kommentarIntro.xsl", $file);
        // return $content;
        $xml = simplexml_load_string($content);
        $asObject = XmlProcessor::XmlToJson($xml);


        $suraClassifier = new SuraClassifier();

        if ($name == 'early-mecca') {
            $introduction = $asObject['Introductions'][0];
            $introduction['how_to_cite'] = Translation::getOnlyGerman(
                $suraClassifier->commentaryCitationKey($name)
            );
        } else if ($name == 'middle-mecca') {
            $introduction = $asObject['Introductions'][1];
            $introduction['how_to_cite'] = Translation::getOnlyGerman(
                "citation_kommentar_mittelmekkanisch"
            );
        } else if ($name == 'late-middle-mecca') {
            $introduction = $asObject['Introductions'][0];
            $introduction['how_to_cite'] = Translation::getOnlyGerman(
                $suraClassifier->commentaryCitationKey($name)
            );
        } else {
            abort(404);
        }

        return response()->json($introduction, 200);
    }
}
