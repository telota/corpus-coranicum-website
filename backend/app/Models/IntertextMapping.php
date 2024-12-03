<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntertextMapping extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.belegstellen_mapping';

    public function scopeByIntertextId($query, $id)
    {
        return $query->where("belegstelle", "=", $id);
    }

    public static function getIntertextsForVerse($sura, $verse)
    {

        $fields = [
            "b.*",
            "m.sure_start",
            "m.vers_start",
            "m.sure_ende",
            "m.vers_ende",
            "k.name as category",
            "ks.name as supercategory",
        ];

        return IntertextMapping::from("corpuscoranicum.belegstellen_mapping as m")
            ->leftJoin("corpuscoranicum.belegstellen as b", "b.id", "=", "m.belegstelle")
            ->leftJoin("corpuscoranicum.belegstellen_kategorie as k", "k.id", "=", "b.kategorie")
            ->leftJoin("corpuscoranicum.belegstellen_kategorie as ks", function ($join) {
                $join->on("k.supercategory", "=", "ks.id");
                $join->where("k.supercategory", "!=", 0);
            })
            ->where('webtauglich', '=', 'ja')
            ->where(function ($query) use ($sura, $verse) {
                $query->where(function ($query) use ($sura) {
                    $query->where('m.sure_start', '<', $sura)
                        ->where('m.sure_ende', '>', $sura);
                })
                    ->orwhere(function ($query) use ($sura, $verse) {
                        $query->where('m.sure_start', '<', $sura)
                            ->where('m.sure_ende', '=', $sura)
                            ->where('m.vers_ende', '>=', $verse);
                    })
                    ->orwhere(function ($query) use ($sura, $verse) {
                        $query->where('m.sure_ende', '>', $sura)
                            ->where('m.sure_start', '=', $sura)
                            ->where('m.vers_start', '<=', $verse);
                    })
                    ->orwhere(function ($query) use ($sura, $verse) {
                        $query->where('m.sure_start', '=', $sura)
                            ->where('m.sure_ende', '=', $sura)
                            ->where('m.vers_start', '<=', $verse)
                            ->where('m.vers_ende', '>=', $verse);
                    });
            })
            ->select($fields)
            ->get();
    }
}
