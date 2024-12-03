<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Variant extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.lc_variante';

    public static function fetchVariants($sura, $verse)
    {
        $fields = [
            'l.id as reading_id',
            'l.kommentar as reading_commentary',
            'v.wort as word',
            'v.variante as variant',
            'll.leser as reader_id',
            'leser.sigle as reader_sigle',
            'q.anzeigetitel as source',
        ];


        $sourceFields = collect(VariantSource::$sourceFields)->map(function ($item) {
            return 'q.' . $item[0] . ' as source_' . $item[1];
        });
        $readerFields = collect(VariantReader::$readerFields)->map(function ($item) {
            return 'leser.' . $item[0] . ' as reader_' . $item[1];
        });

        $fields = array_merge($fields, $sourceFields->toArray(), $readerFields->toArray());

        return Variant::from('corpuscoranicum.lc_variante as v')
            ->leftJoin('corpuscoranicum.lc_leseart as l', 'v.leseart', '=', 'l.id')
            ->leftJoin('corpuscoranicum.lc_leseart_leser as ll', 'l.id', '=', 'll.leseart')
            ->leftJoin('corpuscoranicum.lc_quelle as q', 'l.quelle_id', '=', 'q.id')
            ->leftJoin('corpuscoranicum.lc_leser as leser', 'll.leser', '=', 'leser.id')
            ->select($fields)
            ->where('l.sure', $sura)
            ->where('l.vers', $verse)
            ->get();
    }
}
