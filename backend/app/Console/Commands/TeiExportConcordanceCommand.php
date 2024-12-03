<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\XmlFormatter;
use App\Helpers\XmlProcessor;
use App\Models\QuranConcordance;
use DOMDocument;
use XSLTProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class TeiExportConcordanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:concordance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'stores concordance xml-files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function makeSura(int $sura)
    {
        $words = QuranConcordance::get()
            ->where("sure_cc",$sura)
            ->map(function ($value) {
                return [
                    'sura' => $value->sure_cc,
                    'verse' => $value->vers_cc,
                    'word_no' => $value->wort_cc,
                    'word_rt' => trim($value->word),
                    'word_cc' => trim($value->word_cc),
                    'analysis_no' => $value->analyse,                    
                    'base_rt' => trim($value->base),
                    'base_cc' => trim($value->base_cc),
                    'root_rt' => trim($value->root),
                    'root_cc' => trim($value->root_cc),
                    'analyse_prefix1' => trim($value->prefix1),
                    'analyse_prefix1_part_of_speech' => trim($value->prefix1_part_of_speech),
                    'analyse_prefix1_semantic' => trim($value->prefix1_semantic),
                    'analyse_prefix2' => trim($value->prefix2),
                    'analyse_prefix2_part_of_speech' => trim($value->prefix2_part_of_speech),
                    'analyse_prefix2_semantic' => trim($value->prefix2_semantic),
                    'analyse_prefix3' => trim($value->prefix3),
                    'analyse_prefix3_part_of_speech' => trim($value->prefix3_part_of_speech),
                    'analyse_prefix3_semantic' => trim($value->prefix3_semantic),
                    'analyse_part_of_speech' => trim($value->part_of_speech),
                    'analyse_subcategory' => trim($value->subcategory),
                    'analyse_semantic' => trim($value->semantic),
                    'analyse_semantic2' => trim($value->semantic2),
                    'analyse_pattern' => trim($value->pattern),
                    'analyse_aspect' => trim($value->aspect),
                    'analyse_actpass' => trim($value->actpass),
                    'analyse_mortality' => trim($value->mortality),
                    'analyse_mood' => trim($value->mood),
                    'analyse_prefix' => trim($value->prefix),
                    'analyse_gender' => trim($value->gender),
                    'analyse_number' => trim($value->number),
                    'analyse_casefld' => trim($value->casefld),
                    'analyse_person' => trim($value->person),
                    'analyse_dependent_pron' => trim($value->dependent_pron),
                    'analyse_dependent_person' => trim($value->dependent_person),
                    'analyse_dependent_number' => trim($value->dependent_number),
                    'analyse_dependent_gender' => trim($value->dependent_gender),
                    'analyse_definite' => trim($value->definite),
                    'analyse_diptotic' => trim($value->diptotic),
                    'analyse_full_analyse' => trim($value->full_analyse),
                    'created_at' => $value->created_at,
                    'updated_at' => $value->updated_at,
                ];
            });

        $config = config('cc_xml.concordance.sura');
        $config["filename"] = "sura" . str_pad($sura, 3, '0', STR_PAD_LEFT);
        return TeiExportCommand::createXMLFile($config, ["sura" => $sura, "words" => $words] );
    }
    public function handle()
    {
        $this->info('Working on concordance');
        $start = microtime(true);
        Storage::disk('tei')->deleteDirectory('/concordance/');
        $this->info('create concordance');
        foreach(range(1, 114) as $sura){
            $this->info($this->makeSura($sura));
        }
        $querytime = microtime(true) - $start;
        $this->info('script querytime: ' . $querytime . '');
    }
}
