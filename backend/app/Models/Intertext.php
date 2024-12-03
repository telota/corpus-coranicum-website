<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intertext extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.belegstellen';
    public function scopeFinished()
    {
        return Intertext::where('webtauglich', 'ja');
    }

    public function mentionedInCommentaries()
    {
        return $this->belongsToMany(
            Commentary::class,
            'kommentar_belegstelle',
            'belegstelle_id',
            'sure',
            'ID',
            'sure',
        );
    }

    public static function intertextTableWithCategories()
    {
        return Intertext::from("corpuscoranicum.belegstellen as b")
            ->leftJoin("corpuscoranicum.belegstellen_kategorie as k", "k.id", "=", "b.kategorie")
            ->leftJoin("corpuscoranicum.belegstellen_kategorie as ks", function ($join) {
                $join->on("k.supercategory", "=", "ks.id");
                $join->where("k.supercategory", "!=", 0);
            });
    }
    public static function fetchAllIntertexts()
    {
        $fields = [
            "b.id as id",
            "b.titel as title",
            "b.sprache as language",
            "k.name as category",
            "ks.name as supercategory",
            "m.sure_start as sura",
            "m.vers_start as verse",
        ];

        return Intertext::intertextTableWithCategories()
            ->leftJoin("corpuscoranicum.belegstellen_mapping as m", "m.belegstelle","=","b.id")
            ->where('b.webtauglich', 'ja')
            ->select($fields)
            ->get();
    }

    public static function fetchIntertext($id)
    {
        $fields = [
            "b.*",
            "k.name as category",
            "ks.name as supercategory",
        ];
        $intertext = Intertext::intertextTableWithCategories()
            ->where('b.id', '=', $id)
            ->where('b.webtauglich', '=', "ja")
            ->select($fields)
            ->first();

        if (!isset($intertext)) {
            abort(404);
        }
        return $intertext;
    }


    public function images() {
        return $this->hasMany('App\Models\IntertextImage', 'belegstelle', 'ID');
    }
    public function category() {
        return $this->hasOne('App\Models\IntertextCategory', 'id', 'kategorie');
    }
    public function passages() {
        return $this->hasMany('App\Models\IntertextPassages', 'belegstelle', 'ID');
    }
    public function editors() {
        return $this->hasMany('App\Models\IntertextEditors', 'belegstelle', 'ID');
    } 
}
