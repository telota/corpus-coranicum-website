<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quran;
use App\Models\QuranConcordance;

class ConcordanceController extends Controller
{

    use \Awobaz\Compoships\Compoships;
    # define vars
    private $linkUrl;
    public function __construct()
    {
        parent::__construct();
        $this->linkUrl   = config('cc_config.link_structure.concordance');
    }
    public function data($langauge, $sura = 0, $verse = 0, $word = 0)
    {

        $output = array();
        # check if word exists
        $transcription = Quran::where([
            ['sure', '=', $sura],
            ['vers', '=', $verse],
            ['wort', '=', $word]
        ])
            ->first();

        if (!isset($transcription)) {
            abort(404);
        }

        # get analyzes
        $analyze = QuranConcordance::where([
            ['sure_cc', '=', $sura],
            ['vers_cc', '=', $verse],
            ['wort_cc', '=', $word]
        ])
            ->orderBy('word_num', 'ASC')
            ->get();
        $wordAnalyze = array();
        $i = 0;
        foreach ($analyze as $value) {
            $wordAnalyze[] = array(
                'analysis'      => $value->analyse,
                'word'          => $value->word,
                'word_cc'       => trim($value->word_cc),
                'base'          => $value->base,
                'base_cc'       => $value->base_cc,
                'root'          => $value->root,
                'root_cc'       => $value->root_cc,
                'part_of_speech' => $value->part_of_speech,
                'subcategory'   => $value->subcategory,
                'pattern'       => $value->pattern,
                'aspect'        => $value->aspect,
                'actpass'       => $value->actpass,
                'mortality'     => $value->mortality,
                'mood'          => $value->mood,
                'gender'        => $value->gender,
                'number'        => $value->number,
                'person'        => $value->person,                
                'prefix1'       => $value->prefix1,
                'prefix1_part_of_speech' => $value->prefix1_part_of_speech,
                'prefix1_semantic' => $value->prefix1_semantic,
                'prefix2'       => $value->prefix2,
                'prefix2_part_of_speech' => $value->prefix2_part_of_speech,
                'prefix2_semantic' => $value->prefix2_semantic,
                'prefix3'       => $value->prefix3,
                'prefix3_part_of_speech' => $value->prefix3_part_of_speech,
                'prefix3_semantic' => $value->prefix3_semantic,               
                'semantic'      => $value->semantic,
                'semantic2'     => $value->semantic2,
                'casefld'       => $value->casefld,
                'dependent_pron' => $value->dependent_pron,
                'dependent_person' => $value->dependent_person,
                'dependent_number' => $value->dependent_number,
                'dependent_gender' => $value->dependent_gender,
                'definite'      => $value->definite,
                'diptotic'      => $value->diptotic,
                'full_analyse'  => $value->full_analyse,
            );
            if ($i == 0) {
                $i++;
                $word_cc = $value->word_cc;
                $word_base = $value->base_cc;
            }
        }
        # complete verse
        $sqlTranscription = Quran::where([
            ['sure', '=', $sura],
            ['vers', '=', $verse]
        ])
            ->get();
        $verseArabic            = array();
        $verseTranscription     = array();
        foreach ($sqlTranscription as $value) {
            $verseArabic[]          = $value->arab;
            $verseTranscription[]   = $value->transkription;
        }
        $output = array(
            'analyses'          => $wordAnalyze,
            'arabic_text'       => $verseArabic,
            'transcription_text' => $verseTranscription,
        );
        return response()->json($output, 200);
    }
    private function sqlQuery($field, $word)
    {
        $relations = QuranConcordance::where($field, $word)
            ->select('sure_cc as sura', 'vers_cc as verse', 'wort_cc as word')
            ->addSelect(
                [
                    'whole_vers' => Quran::selectRaw('JSON_ARRAYAGG(transkription)')
                        ->whereColumn('sure', 'sure_cc')
                        ->whereColumn('vers', 'vers_cc')
                        ->orderBy('wort_cc', 'ASC')
                ]
            )
            ->orderBy('sure_cc', 'ASC')
            ->orderBy('vers_cc', 'ASC')
            ->groupBy('sure_cc', 'vers_cc', 'wort_cc')
            ->get()
            ->map(function ($item, $key) {
                $wholeVerseArray = array_map('trim', json_decode($item->whole_vers));
                return [
                    'sura' => $item->sura,
                    'verse' => $item->verse,
                    'word' => $item->word,
                    'transcription_text' => $wholeVerseArray,
                ];
            })->toArray();
        return $relations;
    }
    public function references(Request $request, $field = '', $word = '')
    {
        $result = $this->sqlQuery($field, $word);
        return response()->json($result, 200);
    }
}
