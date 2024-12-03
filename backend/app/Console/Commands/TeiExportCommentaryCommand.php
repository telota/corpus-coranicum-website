<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\XmlFormatter;
use App\Helpers\XmlProcessor;
use App\Models\Commentary;
use DOMDocument;
use XSLTProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class TeiExportCommentaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:commentary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates TEI Commentary Files';

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
    public function handle()
    {
        Storage::disk('tei')->deleteDirectory('/quran_commentary/');
        $this->info("Fetching commentary");
        foreach (Commentary::all() as $commentary) {

            if(
                ($commentary->sure == 0)
                or ($commentary->sure == 67)
                or ($commentary->sure == 72)
                or ($commentary->sure > 114)
            ){
                continue;
            }

            $this->info("Here comes sura {$commentary->sure}");

            $textStruktur = new DOMDocument();
            $text_structure_file = Storage::disk('xml_files')->path('Textstruktur/' . $commentary->text_structure_file);
            $textStruktur->load($text_structure_file);
            $mainCommentary = new DOMDocument();
            $commentary_file = Storage::disk('xml_files')->path('Kommentar/' . $commentary->commentary_file);
            $mainCommentary->load($commentary_file);
            $allCommentary = XmlProcessor::combineXML(
                "body",
                [
                   $textStruktur,
                    $mainCommentary,
                ]
            );

            $output = XmlProcessor::toXml( 'tei/commentary.xsl',null, $allCommentary);
            $output = str_replace("<TEI>", '<TEI xmlns="http://www.tei-c.org/ns/1.0">', $output );


            if (!$output) {

                $this->error("XSLT Error. Check the logs for details");

                return;
            }
            $count = str_pad($commentary->sure, 5, "0", STR_PAD_LEFT);
            Storage::disk('tei')->put(
                "/quran_commentary/sura-{$count}.xml",
                XmlFormatter::format(
                    $output
                )
            );

        }
    }
}
