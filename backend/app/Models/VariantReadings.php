<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantReadings extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;
    protected $table = 'corpuscoranicum.lc_leseart';
    public function sources()
    {
        return $this->belongsTo(VariantReadingsSource::class,
            "quelle_id"
        );

    }
    public function readers()
    {
        return $this->hasManyThrough(
            'App\Models\VariantReadingsReader',
            'App\Models\VariantReadingsToReader',
            'leseart',
            'id',
            'id',
            'leser'
        );
    }
    public function variants()
    {
        return $this->hasMany('App\Models\VariantReadingsVariants', 'leseart', 'id');
    }
    public function quran()
    {
        return $this->hasMany('App\Models\Quran', ['sure', 'vers'], ['sure', 'vers']);
    }
}
