<?php

namespace App\Models;

use App\EloquentBuilders\EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manuscript extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'corpuscoranicum.ms_manuscript';

    public static function getInstance()
    {
        return new self;
    }

    public function newEloquentBuilder($query): Builder
    {
        return new EloquentBuilder($query);
    }

    public function scopePublished($query)
    {
        $query->where('is_online', true);
    }

    public function archive()
    {
        return $this->belongsTo(ManuscriptRepository::class, 'place_id');
    }

    public function pages()
    {
        return $this->hasMany(ManuscriptPage::class, 'manuscript_id')
            ->published()
            ->orderByRaw('LPAD(folio,3,"0")')
            ->orderBy('page_side');
    }

    public function allPages()
    {
        return $this->hasMany(ManuscriptPage::class, 'manuscript_id')
            ->orderByRaw('LPAD(folio,3,"0")')
            ->orderByRaw("FIELD(page_side,'','r','v','bis','bis r', 'bis v','ter','ter r','ter v')");
    }

    public function passages()
    {
        return $this->hasMany(ManuscriptPassage::class, 'manuscript_id')
            ->orderBy('sura_start')
            ->orderBy('verse_start');
    }


    public function provenances()
    {
        return $this->belongsToMany(
            ManuscriptProvenance::class,
            'ms_manuscript_provenances',
            'manuscript_id',
            'provenance_id');
    }
    public function script_styles()
    {
        return $this->belongsToMany(
            ManuscriptScriptStyle::class,
            'ms_manuscript_script_styles',
            'manuscript_id',
            'style_id');
    }
    public function authorRoles()
    {
        return $this->belongsToMany(
            CCAuthorRole::class,
            "ms_manuscript_author_roles",
            "manuscript_id",
            'author_role_id',
        )->using(ManuscriptAuthor::class);
    }
    public function transliterationAuthors()
    {
        return $this->belongsToMany(
            Author::class,
            'ms_manuscript_transliteration_authors',
            'manuscript_id',
            'transliteration_author_id');
    }

    public function title()
    {
        return $this->archive->place_name . ": " . $this->call_number;
    }
}
