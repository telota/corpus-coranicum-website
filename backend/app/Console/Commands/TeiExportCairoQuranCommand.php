<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\CairoQuran;
use App\Console\Commands\TeiExportCommand;

class TeiExportCairoQuranCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:cairo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'stores cairoquran xml-files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->imageFullscreen = config('cc_config.digilib.fullscreen');
    }
    public function allCairoQuram()
    {
        # config data languages and image url
        $data['languages'] = config('cc_xml.cairoquran_languages');
        $imageFullscreen = $this->imageFullscreen;
        # pages of the cairo quran
        $data['manuscript_images'] = CairoQuran::select('Bild')
            ->with('cairoImagesVerses')
            ->groupby('Bild')
            ->get()
            ->map(function ($value) use ($imageFullscreen) {
                return [
                    'page' => $value['Bild'],
                    'image' => Str::replace('[bild]', $value['Bild'], $imageFullscreen),
                    'first' => $value['cairoImagesVerses']->first(),
                    'last' => $value['cairoImagesVerses']->last(),
                    'pageno' => ltrim(preg_replace('/[^0-9]/', '', $value['Bild']), '0'),
                ];
            });
        $appearance = $data['manuscript_images'];
        # get arabic transcription of cairo quram
        $data['arabic'] = [];
        $data['arabic'] = CairoQuran::select('sure')
            ->with('getSuraQuran')
            ->groupby('sure')
            ->get()
            ->map(function ($value) use ($appearance) {
                return [
                    'sura' => $value['sure'],
                    'getSuraQuran' => $value['getSuraQuran']->map(function ($subvalue) use ($appearance) {
                        return [
                            'firstappearance' =>  $appearance->where('page', $subvalue['Bild'])->first() ?? [
                                'first' => [
                                    'sure' => 'not found',
                                    'vers' => 'not found',
                                ],
                                'last' => [
                                    'sure' => 'not found',
                                    'vers' => 'not found',
                                ],
                            ],
                            'sura' => $subvalue['sure'],
                            'verse' => $subvalue['vers'],
                            'page' => $subvalue['Bild'],

                            'pageno' => ltrim(preg_replace('/[^0-9]/', '', $subvalue['Bild']), '0'),
                            'getSuraVerseQuran' => $subvalue['getSuraVerseQuran'],
                        ];
                    }),
                ];
            });
        # get all translations from config - filter the translations language by language
        foreach ($data['languages'] as $language) {
            $data[$language] =  CairoQuran::select('sure')
                ->with('getSuraTranslation')
                ->groupby('sure')
                ->get()
                ->map(function ($value) use ($language) {
                    return [
                        'sura' => $value->sure,
                        'translations' => $value->getSuraTranslation
                            ->filter(function ($filter) use ($language) {
                                return $filter->sprache == $language;
                            })
                            ->map(function ($subvalue) {
                                return [
                                    'text' => $subvalue->text,
                                    'verse' => $subvalue->vers,
                                    'language' => $subvalue->sprache
                                ];
                            })
                    ];
                });
        }
        return TeiExportCommand::createXMLFile(config('cc_xml.cairo.all'), $data);
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);
        $this->info('create cairo quran');
        $this->info(self::allCairoQuram());
        $querytime = microtime(true) - $start;
        $this->info('script querytime: ' . $querytime . '');
    }
}
