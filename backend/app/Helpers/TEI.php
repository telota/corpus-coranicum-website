<?php

namespace App\Helpers;

// use tidy;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Support\Facades\Log;

// use \Illuminate\Support\Facades\Log;

class TEI
{

    public static $elements = [];

    public static function htmlListElements($htmlString)
    {
        $doc = new DOMDocument();
        $doc->loadHTML($htmlString);
        $liList = $doc->getElementsByTagName('li');
        $liValues = array();
        foreach ($liList as $li) {
            $liValues[] = $li->nodeValue;
        }
        return $liValues;
    }

    public static function htmlToTei($htmlString)
    {
        if (strlen($htmlString) == 0) {
            return "";
        }

        $htmlString = "<div>" . $htmlString . "</div>";


        // Replace any forbidden characters
        $htmlString = str_replace(
            [
                "/[\f]/",
                "\r\n",
                "\r",
                "\n",
                "\u{000c}",
                "&nbsp;",
                "<br>",
                "</br>",
            ],
            " ",
            $htmlString
        );

        // Replace all kinds of broken attributes
        $htmlString = preg_replace(
            [
                "/<i.*?>/",
                "/<span.*?>/",
                "/<p.*?>/",
                "/<!.*?>/",
                "/&/",
                "/<…>/",
            ],
            [
                "<i>",
                "<span>",
                "<p>",
                "<!--comment-->",
                "&amp;",
                "&lt;…&gt;"
            ],
            $htmlString);

        Log::debug("Here is the replaced string: $htmlString");

        $dom = new DOMDocument();
        try {
            $dom->loadHTML($htmlString);
        } catch (Exception $e) {
            Log::error("Error loading HTML: " . $e->getMessage());
            Log::error("Here is the faulty html string: $htmlString");
            throw $e;
        }


        $tags = $dom->getElementsByTagName('*');
        foreach ($tags as $child) {

            $name = $child->nodeName;

            if (!isset(self::$elements[$name])) {
                self::$elements[$name] = 0;
            }

            self::$elements[$name] = self::$elements[$name] + 1;

        }
        Log::debug("Here is the string:");
        Log::debug($htmlString);

        $htmlString = XmlProcessor::toXml('tei/WYSIWYG_html.xsl', null, $htmlString);

        $htmlString = preg_replace(["/^<div>/", "/<\/div>$/"], "", $htmlString);

//        Log::info("HERE IS THE STIRNG after the xslt!!!!");
//        Log::info($htmlString);

        return $htmlString;

    }
}
