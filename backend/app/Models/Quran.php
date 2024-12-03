<?php

namespace App\Models;

use App\Exceptions\PayloadTooLargeException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\Range;

class Quran extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;
    protected $guarded = [];
    protected $table = 'corpuscoranicum.lc_kkoran';
    public $timestamps = false;

    public static function queryOverRange($query, Range $range)
    {
        $query->where(function ($query) use ($range) {
            $query
                ->where('sure', '>', $range->start->sura)
                ->where('sure', '<', $range->end->sura);
        })
            ->orwhere(function ($query) use ($range) {
                $query
                    ->where('sure', '=', $range->start->sura)
                    ->where('vers', '>=', $range->start->verse)
                    ->where('sure', '<', $range->end->sura);
            })
            ->orwhere(function ($query) use ($range) {
                $query
                    ->where('sure', '>', $range->start->sura)
                    ->where('sure', '=', $range->end->sura)
                    ->where('vers', '<=', $range->end->verse);
            })
            ->orwhere(function ($query) use ($range) {
                $query
                    ->where('sure', '=', $range->start->sura)
                    ->where('vers', '>=', $range->start->verse)
                    ->where('sure', '=', $range->end->sura)
                    ->where('vers', '<=', $range->end->verse);
            });
    }

    public static function queryOverRanges($query, $ranges)
    {

        collect($ranges)->each(function (Range $range, $key) use ($query) {
            if ($key == 0) {
                $query->where(function ($query) use ($range) {
                    Quran::queryOverRange($query, $range);
                });
            } else {
                $query->orWhere(function ($query) use ($range) {
                    Quran::queryOverRange($query, $range);
                });
            }
        });
    }

    public static function getVerses(array $ranges)
    {
        if (sizeof($ranges) == 0) {
            return collect();
        }
        DB::statement("SET SESSION group_concat_max_len = 1000000;");
        $fields = [
            'sure as sura',
            'vers as verse',
            'group_concat(arab) as arabic',
            'group_concat(transkription) as transcription',
        ];
        $query = Quran::select(DB::raw(implode(", ", $fields)))
            ->groupBy('sure', 'vers')
            ->where('vers', '>', 0);
        
        Quran::queryOverRanges($query, $ranges);
        return $query
            ->orderBy('sure')
            ->orderBy('vers')
            ->get();
    }

    public static function getVerse($sura, $verse)
    {
        return Quran::select('wort as word', 'transkription as transcription', 'arab')
            ->where('sure', $sura)
            ->where('vers', $verse)
            ->get();
    }

    public function getVerseTranslation($sura, $verse)
    {
        return $this->hasOne(
            QuranTranslation::class,
            'sure',
            'sure'
        )
            ->where('vers', 'vers');
    }
}
