<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentary extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'corpuscoranicum.kommentar';
    protected $primaryKey = 'sure';
    public $timestamps = false;


    public static function fetchSura($sura)
    {
        if ($sura < 0 || $sura > 114){
            abort(404);
        }
        $entry = Commentary::where('sure', $sura)->first();
        if (!isset($entry)) {
            abort(404);
        }
        return $entry;
    }

    public static function availableSuras()
    {
        return Commentary::select('sure')
            ->where('sure','>',0)
            ->where('sure','<=', 114)
            ->orderBy('sure', 'asc')
            ->get();
    }

}
