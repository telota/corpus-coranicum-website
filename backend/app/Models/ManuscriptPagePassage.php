<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ManuscriptPage;

class ManuscriptPagePassage extends Model
{
    use HasFactory;

    protected $table = 'corpuscoranicum.ms_manuscript_pages_mapping';
    protected $casts = [
        'sura_start' => 'integer',
        'verse_start' => 'integer',
        'word_start' => 'integer',
        'sura_end' => 'integer',
        'verse_end' => 'integer',
        'word_end' => 'integer',
    ];

    public function page()
    {
        return $this->belongsTo(ManuscriptPage::class, 'manuscript_page_id');
    }

    public function scopePublishedPage($query)
    {
        return $query->whereHas('page', function ($query) {
            $query->published();
            $query->publishedManuscript();
        });
    }
    public function manuscriptpage() {
        return self::belongsTo(ManuscriptPage::class, 'manuscript_page_id');
    }


    public static function publishedManuscriptPages()
    {
        return static::query()
            ->whereHas('manuscriptpage', function ($query) {
                $query->published();
                $query->whereHas('manuscript', function ($query) {
                    $query->published();
                });
            });
    }

    public function scopeCompleteVerse($query)
    {
        return $query
            ->where('sura_start', "<", 999)
            ->where('sura_end', "<", 999)
            ->where('verse_start', "<", 999)
            ->where('verse_end', "<", 999);
    }

    public function scopeSuraAndVerse($query, $sura, $verse)
    {
        return $query->where(function ($query) use ($sura, $verse) {
            $query
                ->where(function ($query) use ($sura) {
                    $query->where('sura_start', '<', $sura)
                        ->where('sura_end', '>', $sura);
                })
                ->orwhere(function ($query) use ($sura, $verse) {
                    $query->where('sura_start', '<', $sura)
                        ->where('sura_end', '=', $sura)
                        ->where('verse_end', '>=', $verse);
                })
                ->orwhere(function ($query) use ($sura, $verse) {
                    $query->where('sura_end', '>', $sura)
                        ->where('sura_start', '=', $sura)
                        ->where('verse_start', '<=', $verse);
                })
                ->orwhere(function ($query) use ($sura, $verse) {
                    $query->where('sura_start', '=', $sura)
                        ->where('sura_end', '=', $sura)
                        ->where('verse_start', '<=', $verse)
                        ->where('verse_end', '>=', $verse);
                });
        });
    }
}
