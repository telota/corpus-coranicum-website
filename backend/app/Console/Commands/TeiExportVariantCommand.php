<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VariantReadings;
use App\Models\VariantReadingsSource;
use App\Models\VariantReadingsReader;
use App\Console\Commands\TeiExportCommand;

class TeiExportVariantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:variants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'stores varitan xml-files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    # XML for Variants
    public function allVariantSources()
    {
        $sources = VariantReadingsSource::all()
            ->map(function ($value) {
                return [
                    'id' => $value['id'],
                    'title_display' => $value['anzeigetitel'],
                    'author_long'  => $value['autor_langfassung'],
                    'source_arabic' => $value['quelle_arabisch'],
                ];
            });
        return TeiExportCommand::createXMLFile(config('cc_xml.variants.sources'), $sources);
    }
    public function allVariantReader()
    {
        $reader = VariantReadingsReader::all()
            ->map(function ($value) {
                return [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'name_display' => $value['anzeigename'],
                    'sigle' => $value['sigle'],
                    'location' => $value['ort'],
                    'date_of_death' => $value['todesdatum'],
                    'comment' => TeiExportCommand::removeHtml($value['kommentar']),
                ];
            });
        return TeiExportCommand::createXMLFile(config('cc_xml.variants.reader'), $reader);
    }
    public function allVariants()
    {
        $readings  = VariantReadings::select('id', 'sure', 'vers', 'kanonisch')
            ->with(
                [
                    'readers',
                    'sources',
                    'variants',
                    'quran'
                ]
            )
            ->select('id', 'sure', 'vers', 'kanonisch')
            ->get()
            ->map(function ($value) {
                return [
                    'id' => $value['id'],
                    'readers' => $value['readers'],
                    'variants' => $value['variants'],
                    'sura' => $value['sure'],
                    'verse' => $value['vers'],
                ];
            });
        return TeiExportCommand::createXMLFile(config('cc_xml.variants.allvariants'), $readings);
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);
        $this->info('create variants');
        $this->info(self::allVariantSources());
        $this->info(self::allVariantReader());
        $this->info(self::allVariants());
        $querytime = microtime(true) - $start;
        $this->info('script querytime: ' . $querytime . '');
    }
}
