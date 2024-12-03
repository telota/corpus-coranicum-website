<?php

namespace App\Models;

use App\EloquentBuilders\EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptImage extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.ms_manuscript_pages_images';
    
    public function newEloquentBuilder($query): Builder
    {
        return new EloquentBuilder($query);
    }
    public function manuscriptpage()
    {
        return self::belongsTo(ManuscriptPage::class, 'manuscript_page_id');
    }
    public static function publishedManuscriptPages()
    {
        return static::query()
        ->imagePublished()
        ->whereHas('manuscriptpage', function ($query) {
            $query->imagePagePublished();
            $query->whereHas('manuscript', function ($query) {
                $query->imagePagePublished();
            });
        });
    }
}
