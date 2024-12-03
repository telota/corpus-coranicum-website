<?php

namespace App\Http\Controllers;

use App\Models\CairoQuran;
use App\Models\Quran;
use App\Models\QuranConcordance;
use App\Models\QuranTranslation;
use \Illuminate\Support\Facades\Log;

class PrintedEditionController extends Controller
{
    # define vars
    private $imageFullscreen;
    public function __construct()
    {
        parent::__construct();
        $this->imageFullscreen = config('cc_config.digilib.fullscreen');
    }
    # generate output as json
    public function data($language = '', $sura = 0, $verse = 0)
    {
        ## get values from db
        # create general value
        $quran = CairoQuran::where([
            ['sure', '=', $sura],
            ['vers', '=', $verse]
        ])
            ->first();
        # translation of quram
        $quramTranslation = QuranTranslation::where([
            ['sure', '=', $sura],
            ['vers', '=', $verse],
            ['sprache', '=', $language]
        ])
            ->first();
        # create arrays for words
        $transcription = Quran::where([
            ['sure', '=', $sura],
            ['vers', '=', $verse]
        ])
            ->get();
        $textArabic            = array();
        $textTranscription     = array();
        foreach ($transcription as $value) {
            $textArabic[]          = $value->arab;
            $textTranscription[]   = $value->transkription;
        }
        # analyzes
        $analyze = QuranConcordance::where([
            ['sure_cc', '=', $sura],
            ['vers_cc', '=', $verse]
        ])
            ->orderBy('word_num', 'ASC')
            ->get();
        $wordAnalyze = array();
        // Log::debug(print_r($analyze, true));
        foreach ($analyze as $word) {
            Log::debug($word->word_num - 1);
            Log::debug($word->analyse - 1);
            $wordAnalyze[($word->word_num - 1)][] = $word->full_analyse;
        }
        # create output         
        $output = array(
            'image_file'          => $quran->Bild,
            'image_url'      => str_replace('[bild]', $quran->Bild, $this->imageFullscreen),
            'iiif_url'      => str_replace(['[bild]', '.JPG'], [$quran->Bild, ''], config('cc_config.digilib.iiif') . 'Kairo1924![bild]/info.json'),
            'arabic_text'           => $textArabic,
            'transcription_text'    => $textTranscription,
            'transcription_analysis' => $wordAnalyze,
            'translation'           => $quramTranslation->text,
        );
        return response()->json($output, 200);
    }
    # generate output as json
    public function concordance($language = '', $sura = 0, $verse = 0)
    {
        # analyzes
        $analyze = QuranConcordance::where([
            ['sure_cc', '=', $sura],
            ['vers_cc', '=', $verse]
        ])
            ->orderBy('word_num', 'ASC')
            ->get();
        $wordAnalyze = array();
        foreach ($analyze as $word) {
            $wordAnalyze[($word->word_num - 1)][($word->analyse - 1)] = $word->full_analyse;
        }
        # create output         
        $output = array(
            'transription_analysis' => $wordAnalyze,
        );
        return response()->json($output, 200);
    }
}
