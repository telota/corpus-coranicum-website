<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.translations';
    public $timestamps = false;
    public function scopegetSuraAndVerses($sura_from, $verse_from, $sura_to, $verse_to)
    {
        return '';
    }


    public static function fetchTranslations($language, $translationlist)
    {
        $fallbackLanguage = config('cc_config.fallback_language');
        $query = Translation::select(
            'key',
            $language,
            $fallbackLanguage
        );
        $i = 0;
        foreach ($translationlist as $value) {
            if ($i == 0) {
                $query->Where('key', $value);
            } else {
                $query->orWhere('key', $value);
            }
            $i++;
        }
        $translations = $query->get()->toArray();
        foreach ($translations as $value) {
            $trans_array[$value['key']] = (!empty($value[$language])) ?  $value[$language] : ($value[$fallbackLanguage] ?? '[english label is missing]');
        }
        return ($trans_array ?? []);
    }

    public static function getOnlyGerman($key){
        return Translation::select('de')->where('key',$key)->first()->de ?? null;
    }
}
