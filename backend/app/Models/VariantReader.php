<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantReader extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.lc_leser';

    public static $readerFields = [
        ['anzeigename', 'display_name'],
        ['id', 'id'],
        ['name', 'name'],
        ['sigle', 'sigle'],
        ['todesdatum', 'death_year'],
        ['todesdatum_ah', 'death_year_arabic'],
        ['kommentar', 'infotext'],
    ];

    public static function getCanonicalReaders()
    {
        $sigles = [];
        for ($i = 1; $i <= 7; $i++) {
            $sigles[] = "0" . $i . "00";
            $sigles[] = "0" . $i . "01";
            $sigles[] = "0" . $i . "02";
        }

        $selectFields = collect(VariantReader::$readerFields)->map(function ($item) {
            return $item[0] . ' as ' . $item[1];
        });
        $query = VariantReader::select(...$selectFields);

        foreach ($sigles as $sigle) {
            $query = $query->orWhere('sigle', $sigle);
        }

        return $query->get();
    }
}
