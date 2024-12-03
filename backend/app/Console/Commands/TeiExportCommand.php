<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\XmlFormatter;

class TeiExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'enter "all" as option, if you want to export all files. Other possible options are "intertexts", "cairo", "concordance" and "variants"';

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
    public static function createXMLFile($meta, $data)
    {
        $xml =
            XmlFormatter::format(
                view($meta['template'], [
                    'data'    => $data,
                ])->render()
            );
        Storage::disk('tei')->put($meta['folder'] . $meta['filename'] . '.xml', $xml);
        return 'XML File ' . $meta['filename'] . '.xml  created';
    }
    public static function removeHtml($string) {
        return strip_tags(
            Str::replace(
                '&nbsp;',
                ' ',
                $string
            )
            );
    }
    public static function formatIntertextLiterature($literature)
    {
        # extract literature from html list language
        $literature = Str::replace('<ul>', '', $literature);
        $literature = Str::replace('</ul>', '', $literature);
        $literature = Str::replace('</li>', '', $literature);
        $literature = explode('<li>', $literature);
        $literature = array_map('trim', $literature);
        $literature = array_filter($literature);
        return $literature;
    }

    public function handle()
    {
        $start = microtime(true);
        $this->call('tei:meta-texts');
        $this->call('tei:cairo');
        $this->call('tei:intertexts');
        $this->call('tei:variants');
        $this->call('tei:manuscripts');
        $this->call('tei:manuscript-places');
        $this->call('tei:commentary');
        $this->call('tei:concordance');
        $querytime = microtime(true) - $start;
        $this->info('script querytime: ' . $querytime . '');
    }
}
