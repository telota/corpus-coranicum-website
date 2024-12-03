<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuranConcordance extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;
    protected $table = 'corpuscoranicum.qortbl2 as main';
    public $timestamps = false;
    public function transcriptionText()
    {
        return $this->hasMany(
            Quran::class,
            ['sure', 'vers'],
            ['sura', 'verse']
        )
            ->select('sure', 'vers', 'wort', 'transkription')
            ->orderBy('wort', 'ASC');
    }
}
