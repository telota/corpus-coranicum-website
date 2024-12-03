<?php

namespace App\Models;

use App\EloquentBuilders\EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptPage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'corpuscoranicum.ms_manuscript_pages';

    public function manuscript()
    {
        return $this->belongsTo(Manuscript::class, 'manuscript_id');
    }

    public function old_manuscript()
    {
        return $this->belongsTo(OldManuscript::class, 'manuscript_id', 'ID')->published();
    }
    public function newEloquentBuilder($query): Builder
    {
        return new EloquentBuilder($query);
    }

    public function scopePublished($query)
    {
        $query->where('is_online', true);
    }

    public function scopePublishedManuscript($query)
    {
        return $query->whereHas('manuscript', function ($query) {
            $query->published();
        })->orWhereHas('old_manuscript', function ($query) {
            $query->published();
        });
    }
    public static function publishedManuscripts()
    {
        return static::query()
            ->published()
            ->whereHas('manuscript', function ($query) {
            });
    }
    public function passages()
    {
        return $this->hasMany(ManuscriptPagePassage::class, 'manuscript_page_id')
            ->completeVerse()
            ->orderBy('sura_start')
            ->orderBy('verse_start')
            ->orderBy('word_start');
    }

    public function justIds()
    {
        return $this->publishedManuscripts()->pluck('id');
    }

    public function images()
    {
        return $this->hasMany(ManuscriptImage::class, 'manuscript_page_id')->where('private_use_only', false);
    }

}
