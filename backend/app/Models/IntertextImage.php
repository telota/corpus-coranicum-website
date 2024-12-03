<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntertextImage extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.belegstellen_bilder';

    public static function fetchForIntertext($id)
    {
        return IntertextImage::where("belegstelle", $id)
			->select("bildlink", "bildnachweis")
            ->get();
    }
}
