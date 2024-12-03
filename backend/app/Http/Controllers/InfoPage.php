<?php

namespace App\Http\Controllers;

use App\Models\HtmlContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use \Illuminate\Support\Facades\Log;
use App\Models\Translation;
use App\Helpers\Utilities;


class InfoPage extends Controller
{
    public static $translate = "translate";
    public static $team_list = "team_list";
    public static $curl = "curl";


    private static function getDatabaseMember($label)
    {
        $list = [];
        foreach (config('cc_database.' . $label) as $value) {
            $list[] = (!empty($value['url'])) ? '<a href="' . $value['url'] . '" target="_blank">' . $value['label'] . '</a>' : $value['label'];
        }
        return $list;
    }

    private static function getDataFromWebpage($label)
    {
        $config = config('cc_curl.' . $label);
        $classname = $config['container'];
        $sourcecode = file_get_contents($config['url']);
        $sourcecode = mb_convert_encoding($sourcecode, 'HTML-ENTITIES', "UTF-8");
        $data = '';
        $html = new \DOMDocument();
        $html->loadHTML($sourcecode);
        $xpath = new \DomXPath($html);
        $nodes = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        $tmp_dom = new \DOMDocument();
        foreach ($nodes as $node) {
            $tmp_dom->appendChild($tmp_dom->importNode($node, true));
        }
        $data .= trim($tmp_dom->saveHTML());

        return $data;
    }

    public static function replaceWithTranslations($config, $translations)
    {
        if (!is_array($config)) {
            return $config;
        }
        if (array_key_exists(InfoPage::$translate, $config)) {
            if (isset($translations[$config[InfoPage::$translate]]))
                return $translations[$config[InfoPage::$translate]];

            return null;
        }
        if (array_key_exists(InfoPage::$team_list, $config)) {
            return $translations[$config[InfoPage::$team_list]];
        }
        if (array_key_exists(InfoPage::$curl, $config)) {
            return $translations[$config[InfoPage::$curl]];
        }
        $copy = [];
        foreach ($config as $k => $v) {
            $copy[$k] = InfoPage::replaceWithTranslations($v, $translations);
        }
        return $copy;
    }

    public function fillHtmlContent($language, $webItems){
        $htmlLabels = [];
        foreach ($webItems as $key => $item) {
            if ((isset($item['html'])) and (!isset($item['html']['curl']))) {
                $htmlLabels[] = $item['html'];
            }
        }

        $htmlContentByLabel = HtmlContent::whereIn('label', $htmlLabels)->get()->keyBy('label');
        if(sizeof($htmlContentByLabel) == 0){
            return $webItems;
        }

        foreach ($webItems as $key => $item) {
            $htmlContent = null;
            $fallback_language = config('cc_config.fallback_language');
            if(!isset($item['html'])){
                continue;
            }
            if (isset($htmlContentByLabel[$item['html']])) {
                $content = $htmlContentByLabel[$item['html']];
                if (isset($content->$language)) {
                    $htmlContent = $content->$language;
                } elseif (isset($content->$fallback_language)) {
                    $htmlContent = $content->$fallback_language;
                } else {
                    $htmlContent = $content->de;
                }

                $webItems[$key]['html'] = $htmlContent;
            }
        }
        # set htmlcurl to html
        foreach ($webItems as $key => $subArray) {
            foreach ($subArray as $subKey => $value) {
                if ($subKey === 'htmlcurl') {
                    unset($webItems[$key][$subKey]);
                    $webItems[$key]['html'] = $value;
                }
            }
        }
        return $webItems;

    }

    public function getPage($language, $website)
    {
        $config = "website_" . $website;

        if (config()->has($config)) {

            $items = config($config);

            $items = $this->fillHtmlContent($language, $items);
            $listKeys = [];
            $translationKeys = [];
            $curlKeys = [];
            array_walk_recursive(
                $items,
                function ($item, $key) use (&$translationKeys, &$listKeys, &$curlKeys) {
                    if ($key == InfoPage::$translate) {
                        $translationKeys[] = $item;
                    } else if ($key == InfoPage::$team_list) {
                        $listKeys[$item] = self::getDatabaseMember($item);
                    } else if ($key == InfoPage::$curl) {
                        $curlKeys[$item] = self::getDataFromWebpage($item);
                    }
                }
            );
            $translations = Translation::fetchTranslations($language, $translationKeys);
            $replaceKey = array_merge($translations, $listKeys, $curlKeys);
            return response()
                ->json(InfoPage::replaceWithTranslations(
                    $items,
                    $replaceKey
                ), 200);
        }
        abort(404);
    }
}
