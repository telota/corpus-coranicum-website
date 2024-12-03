<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Log;
use App\Models\Translation;

class TranslationsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function shortTranslations(Request $request, $language)
    {
        $fallback = config('cc_config.fallback_language');

        $db = Translation::select(
            'key',
            $language,
            $fallback
        )
            ->get();

        $translations = [];
        foreach ($db as $translation) {
            $translations[$translation->key] = [
                "translation" => $translation->$language,
                "fallback_translation" => $translation->$fallback,
            ];
        }

        Log::debug(print_r($translations, TRUE));

        foreach (config('config_translations') as $key => $db_key) {
            $output[$key] = $this->addTranslation($db_key, $translations);
        }
        return ($output);
    }

    private function addTranslation($value, $translations)
    {

        if (is_string($value)) {
            if (strlen(trim($translations[$value]["translation"])) > 0) {
                return $translations[$value]["translation"];
            }
            return $translations[$value]["fallback_translation"];
        }

        foreach ($value as $key => $subvalue) {
            $output[$key] = $this->addTranslation($subvalue, $translations);
        }
        return $output;
    }

    public function website(Request $request)
    {
        if (is_array(config('cc_api.' . $request['category']))) {
            $config = config('cc_api.' . $request['category']);
            $labelTranslations = Translation::fetchTranslations($request->language, $config);
            foreach ($labelTranslations as $key => $value) {
                $temp = array_keys($config, $key);
                $translations[array_shift($temp)] = $value ?? null;
            }
            # create output         
            return response()->json($translations, 200);
        }
        abort(404);
    }
    public function pages(Request $request)
    {
        $output = [];
        if (!empty(config('config_pages.' . $request->page))) {
            $pagearray = config('config_pages.' . $request->page);
            # get translations
            $db = Translation::select(
                'key',
                $request->language . ' as translation'
            )
                ->get()
                ->toArray();
            $translations = [];
            foreach ($db as $value) {
                $translations[$value['key']] = $value['translation'];
            }
            # write output file
            foreach ($pagearray as $value) {
                $output[] = [
                    'tag'   => $value[0],
                    'value' => ($value[2] == true) ? $translations[$value[1]] : $value[1],
                ];
            }
            return response()->json($output, 200);
        } else {
            return response()->json(['error' => '#440 page does not exist'], 404);
        }
    }
}
