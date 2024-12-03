<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldManuscript extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'corpuscoranicum.manuskript';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;

    # manuscript fields not used on website:  preferred_image_source, Textspiegel, Textgliederung, Text, Bild, Fundort, Ornamente


    public function scopePublished($query)
    {
        $query->where('webtauglich', 'ja')
            ->orwhere('webtauglich', 'ohneBild');
    }

    public function pages()
    {
        return $this->hasMany(ManuscriptPage::class, 'manuscript_id', 'ID')
            ->published()
            ->orderByRaw('LPAD(folio,3,"0")')
            ->orderBy('page_side');
    }

    public function passages()
    {
        return $this->hasMany(ManuscriptPassage::class, 'manuscript_id',)
            ->orderBy('sura_start')
            ->orderBy('verse_start')
            ->orderBy('word_start');
    }

    public function archive()
    {
        return $this->belongsTo(ManuscriptRepository::class, 'place_id', 'id');
    }
}
