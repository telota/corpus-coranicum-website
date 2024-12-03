<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptPassage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'corpuscoranicum.ms_manuscript_mapping';
    protected $casts = [
        'sura_start' => 'integer',
        'verse_start' => 'integer',
        'sura_end' => 'integer',
        'verse_end' => 'integer',
    ];
    public function manuscript()
    {
        return self::belongsTo(Manuscript::class, 'manuscript_id');
    }
    public static function publishedManuscripts()
    {
        return static::query()
            ->whereHas('manuscript', function ($query) {
                $query->published();
            });
    }
}
