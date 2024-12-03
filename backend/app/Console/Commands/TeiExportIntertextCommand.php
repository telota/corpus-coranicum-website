<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Intertext;
use App\Models\IntertextCategories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Console\Commands\TeiExportCommand;

class TeiExportIntertextCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:intertexts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'stores intertext xml-files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    # xml for intertexts
    public function intertextsCategories()
    {
        $categories = IntertextCategories::select('id', 'name', 'classification')
            ->with('subCategories')
            ->where('supercategory',  0)
            ->where('id', '>', 0)
            ->get()
            ->map(function ($value) {
                return [
                    'name' => $value['name'],
                    'classification' => $value['classification'],
                    'subcategories' => $value['subCategories'],
                ];
            });
        return TeiExportCommand::createXMLFile(config('cc_xml.intertexts.categories'), $categories);
    }
    public function allIntertexts()
    {
        # languages
        $languages = config('cc_xml.languages');
        # Get all files in a directory
        $files =   Storage::allFiles(config('cc_xml.intertexts.all.folder'));
        # Delete Files
        Storage::delete($files);
        $intertexts = Intertext::with([
            'images',
            'category',
            'passages',
            'editors'
        ])
            ->where('webtauglich',  'ja')
            ->get()
            ->map(function ($value) use ($languages) {
                return [
                    'id' => $value['ID'],
                    'language' => $value['Sprache'],
                    'language_original' => TeiExportCommand::removeHtml($value['Originalsprache']),
                    'title' => $value['Titel'],
                    'annotations' => TeiExportCommand::removeHtml($value['Anmerkungen']),
                    'author' => $value['Autor'],
                    'date' => TeiExportCommand::removeHtml($value['Datierung']),
                    'location' => $value['Ort'],
                    'editors' => $value['editors'],
                    'edition' => TeiExportCommand::removeHtml($value['Edition']),
                    'language-iso-639-3' => array_search($value['Sprache'], $languages, 'int'),
                    'translation' => [
                        'de' => TeiExportCommand::removeHtml($value['Uebersetzung_dt']),
                        'en' => TeiExportCommand::removeHtml($value['Uebersetzung_en']),
                    ],
                    'literature_formatted' => TeiExportCommand::formatIntertextLiterature($value['Literatur']),
                    'images' => $value['images'],
                ];
            });
        $i = 0;
        foreach ($intertexts as $intertext) {
            $config_intertext = config('cc_xml.intertexts.all');
            $count = str_pad($intertext['id'], 5, "0", STR_PAD_LEFT);
            $config_intertext['filename'] = Str::replace('[id]', $count, $config_intertext['filename']);
            $info = TeiExportCommand::createXMLFile($config_intertext, $intertext);
            $this->info($info);
            $i++;
        }
        return $i . ' XML intertext-files created';
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);
        $this->info('create intertexts');
        $this->info(self::intertextsCategories());
        $this->info(self::allIntertexts());
        $querytime = microtime(true) - $start;
        $this->info('script querytime: ' . $querytime . '');
    }
}
