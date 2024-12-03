<?php

namespace App\Helpers;

use DOMDocument;
use Mockery\Exception;
use XSLTProcessor;
use \Illuminate\Support\Facades\Log;

class XmlProcessor
{

    public static function combineXML(string $rootNodeName, $domDocuments): string
    {

        $dom = new DOMDocument('1.0', 'utf-8');

        $element = $dom->createElement($rootNodeName);
        $dom->appendChild($element);
        foreach ($domDocuments as $domDocument) {
            $node = $dom->importNode($domDocument->documentElement, true);
            $element->appendChild($node);
        }

        return $dom->saveXML();
    }

    public static function toXml($template, $xmlFile = null, $xmlString = null,)
    {

        $xsl = new DOMDocument();
        $processor = new XSLTProcessor();
        libxml_use_internal_errors(true);

        $xsl->load(resource_path('xsl/' . $template));
        $processor->importStyleSheet($xsl);
        $dom = new DomDocument();
        if (isset($xmlFile)) {
            $loaded = $dom->load($xmlFile);
        } else {
            $loaded = $dom->loadXML($xmlString);
        }


        if (!$loaded) {
            $errors = libxml_get_errors();
            Log::error(json_encode($errors, JSON_PRETTY_PRINT));
            throw new Exception('Error loading xml');
        }

        $output = $processor->transformToXml($dom);

        return trim($output);
    }

    public static function XmlToJson($simpleXml)
    {
        $type = $simpleXml->attributes()['type'];
        switch ($type) {
            case "array":
                $array = [];
                foreach ($simpleXml->children() as $node) {
                    $array[] = XmlProcessor::XmlToJson($node);
                }
                return $array;
                break;
            case "html":
                $htmlString = "";
                foreach ($simpleXml->children() as $child) {
                    $htmlString .= $child->asXml();
                }
                return $htmlString;
            case "int":
                return (int)$simpleXml;
            case "bool":
                if ((string)$simpleXml == 'false') {
                    return false;
                }
                return (bool)$simpleXml;
            default:
                if (count($simpleXml->children()) == 0) {
                    return (string)$simpleXml;
                }
                $object = [];
                foreach ($simpleXml as $key => $value) {
                    $object[$key] = XmlProcessor::XmlToJson($simpleXml->$key);
                }
                return $object;
        }
    }
}
