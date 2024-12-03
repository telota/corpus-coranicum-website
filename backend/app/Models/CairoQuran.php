<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CairoQuran extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;
    protected $guarded = [];
    protected $table = 'corpuscoranicum.koran';
    public $timestamps = false;
    protected $primaryKey = 'ID';
    public function translation()
    {
        return $this->hasOne(
            QuranTranslation::class,
            'sure',
            'sure'
        )
            ->where('vers', 'vers');
    }

    public static function getAllRowsForCounting()
    {
        return CairoQuran::select('sure', 'vers', 'surenname', 'koranstelle')->get();
    }

    public static function getAllRowsForPageMapping()
    {
        return CairoQuran::select('sure as sura', 'vers as verse', 'Bild')->get();
    }

    public static function getVerseCounts()
    {
        $query = CairoQuran::select('sure as sura', DB::raw('max(vers) as verses'))
            ->groupBy('sure')
            ->get();
        $verse_counts = array();
        foreach ($query as $sura) {
            $verse_counts[$sura->sura] = $sura->verses;
        }
        return $verse_counts;
    }

    //Note: this seems like the wrong table for reading variants commentary
    public static function getReadingVariantsCommentary($sura, $verse)
    {
        return CairoQuran::select('kommentar as commentary')
            ->where('sure', $sura)
            ->where('vers', $verse)
            ->first();
    }
    public function getSuraTranslation()
    {
        return $this->hasMany(QuranTranslation::class, 'sure', 'sure')
            ->orderby('vers');
    }
    public function getSuraQuran()
    {
        return $this->hasMany(CairoQuran::class, 'sure', 'sure')
            ->select(['sure', 'vers', 'Bild'])
            ->with('getSuraVerseQuran');
    }
    public function getSuraVerseQuran()
    {
        return $this->hasMany(Quran::class, ['sure', 'vers'], ['sure', 'vers'])
            ->select(['sure', 'vers', 'wort', 'arab', 'transkription'])
            ->orderby('vers', 'asc')
            ->orderby('wort', 'asc');
    }
    public function cairoImagesVerses()
    {
        return $this->hasMany(CairoQuran::class, 'Bild', 'Bild')
        ->select(['Bild', 'sure', 'vers'])
        ->orderby('sure', 'asc')
        ->orderby('vers', 'asc');
    }
    public function cairoImagesVersesWithSuren()
    {
        return $this->hasMany(CairoQuran::class, 'Bild', 'Bild')
        ->select(['Bild', 'sure', 'vers'])
        ->orderby('sure', 'asc')
        ->orderby('vers', 'asc')->with('getSuraVerseQuran');
    }
}
