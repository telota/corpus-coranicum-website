<?php

namespace App\Console\Commands;

use App\Helpers\TEI;
use Exception;
use Illuminate\Console\Command;
use App\Helpers\XmlFormatter;
use App\Helpers\XmlProcessor;
use DomDocument;
use App\Models\OldManuscript;
use App\Models\Manuscript;
use App\Models\ManuscriptRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TeiExportManuscriptCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:manuscripts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates TEI Manuscript files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private static function getTransliteration($manuscript)
    {
        if ($manuscript->transliteration_alt) {
            $doc = new DOMDocument();
            $doc->loadXML($manuscript->transliteration_alt);
            return $doc->saveXML($doc->documentElement);
        }
        $transliteration_file = $manuscript->transliteration_file;
        if ($transliteration_file) {
            $path = Storage::disk('xml_files')
                ->path('Manuskript/' . $transliteration_file);
            $doc = new DOMDocument();
            $doc->load($path);
            return $doc->saveXML($doc->documentElement);
        }
        return "";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    private function getManuscripts()
    {

        $manuscripts = Manuscript::with(
            'archive',
            'provenances',
            'authorRoles.role.module',
            'authorRoles.author',
            'pages.passages',
            'pages.images',
            'passages',
        )
//            ->where('id', 2339)
            ->published()
            ->get();
        $this->info('Got the manuscripts...');
        #  print_r($manuscripts->toArray());
        foreach ($manuscripts as $manuscript) {
            $this->info('Working on TEI output for manuscript ' . $manuscript->id . '.');

            $manuscript->transliteration = TeiExportManuscriptCommand::getTransliteration($manuscript);
            // For debug purposes
            // Storage::disk('tei')->put(
            //     $directory . '/' . $manuscript->ID . ".json",
            //     $manuscript->toJson(JSON_PRETTY_PRINT)
            // );
            //For debug purposes
            // Storage::disk('tei')->put(
            //     '/manuscripts/' . $manuscript->ID . '_debug.xml',
            //     View::make('tei/manuscripts/manuscript')
            //         ->with('manuscript', $manuscript)
            //         ->render()
            // );

            #   print_r($manuscript->pages->toArray());
            $image_credits = $manuscript
                ->pages
                ->pluck('images')
                ->flatten()
                ->pluck('credit_line_image')
                ->unique()
                ->values()
                ->filter();
            foreach ($manuscript->pages as $page) {
                foreach ($page->images as $image) {
                    $image->credit = $image_credits->search($image->credit_line_image);
                }
            }
            $count = str_pad($manuscript->id, 5, "0", STR_PAD_LEFT);
            try{

            Storage::disk('tei')->put(
                "/quran_manuscripts/manuscript-{$count}.xml",
                XmlFormatter::format(
                    View::make('tei/manuscripts/manuscript')
                        ->with('manuscript', $manuscript)
                        ->with('image_credits', $image_credits)
                        ->render()
                )
            );
            }catch (Exception $e) {
                $this->error("Error generating TEI for manuscript " . $manuscript->id);
                $this->error("Check the logs for more info.");
            }
        }
        $this->info('TEI output for manuscripts in complete.');
        $this->info("Here are all the html tags we found:");
        foreach (TEI::$elements as $key => $value) {
            $this->info($key . " " . $value);
        }
    }

    public function handle()
    {
        $this->info('Working on manuscripts');
        $path = Storage::disk('tei')->path('/quran-manuscripts/');
        $files = glob($path . '/manuscript*');

        foreach ($files as $file) {
            unlink($file); // Delete each file
        }
        $start = microtime(true);
        self::getManuscripts();
        $querytime = microtime(true) - $start;
        $this->info('script querytime: ' . $querytime . '');
    }
}
