<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Range;

class QuranTranslation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'corpuscoranicum.koran_uebersetzung';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(CairoQuran::class);
    }
    public static function getVerses($language, array $ranges)
    {

        if (sizeof($ranges) == 0) {
            return collect([]);
        }

        return QuranTranslation::select('sure as sura', 'vers as verse', 'text')
            ->where('vers', '>', 0)
            ->where('sprache', '=', $language)
            ->where(function ($query) use ($ranges) {
                Quran::queryOverRanges($query, $ranges);
            })
            ->orderBy('sure')
            ->orderBy('vers')
            ->get();
    }
}
