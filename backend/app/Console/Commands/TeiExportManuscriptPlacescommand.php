<?php

namespace App\Console\Commands;

use App\Models\ManuscriptRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TeiExportManuscriptPlacescommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:manuscript-places';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private function getPlaces() {
        $places = ManuscriptRepository::get()
            ->map(function ($value) {
                return [
                    'id' => $value['id'],
                    'place' => $value['place'],
                    'place_name' => $value['place_name'],
                    'geonames_id' => $value['geonames'],
                    'place_url' => $value['link'],
                    'place_longitude' => $value['longitude'],
                    'place_latitude' => $value['latitude'],
                    'place_description' => TeiExportCommand::removeHtml($value['description']),
                    'place_iso3166_2' => $value['country_code'],
                    'image_copyrights' => $value['image_description'],
                    'image_url' =>  (!empty($value['image_link'])) ? Str::replace('[bild]', $value['image_link'], config('cc_config.digilib.local')) :'' ,
                ];
            });
        return TeiExportCommand::createXMLFile(config('cc_xml.manuscripts.places'), $places);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);
        $this->info('create manuscript places');
        self::getPlaces();
        $querytime = microtime(true) - $start;
        $this->info('script querytime: ' . $querytime . '');
    }
}
