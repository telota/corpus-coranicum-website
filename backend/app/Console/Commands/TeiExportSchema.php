<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TeiExportSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tei:meta-texts';

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

    public function copyTeiFile($file, bool $schemaFolder = true)
    {
        if ($schemaFolder) {
            $dest = "schema/$file";
        } else {
            $dest = $file;
        }

        Storage::disk('tei')->delete($dest);
        Storage::disk('tei')
            ->writeStream(
                $dest,
                fopen(resource_path("views/tei/$file"), 'r')
            );

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Copying over the readme, the .rng schema,  and .odd');
        $this->copyTeiFile("corpus_coranicum.rng");
        $this->copyTeiFile("README.md", false);
        $this->copyTeiFile("corpus_coranicum.odd");
    }
}
