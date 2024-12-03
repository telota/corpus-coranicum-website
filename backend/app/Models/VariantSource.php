<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VariantSource extends Model
{
    use HasFactory;

    protected $table = 'corpuscoranicum.lc_quelle';

    public static $sourceFields = [
        ['id', 'id'],
        ['anzeigetitel', 'display_name'],
        ['autor_langfassung', 'name'],
        ['todesdatum', 'death_year'],
        ['todesdatum_ah', 'death_year_arabic'],
        ['referenz', 'bibliographic_reference'],
        ['kanonisch', 'canonical']
    ];

    public static function getCanonicalSource()
    {
        $selectFields = collect(VariantSource::$sourceFields)->map(function ($item) {
                return $item[0] . ' as ' . $item[1];
            });

        return VariantSource::select(...$selectFields)
            ->where('kanonisch', '1')
            ->where('id', '16')
            ->first();
    }

    public function citations(): BelongsToMany
    {
        return $this->belongsToMany(CCAuthorRole::class,
            "lc_quelle_author_roles",
            "quelle_id",
            "author_role_id",
        );
    }

}
