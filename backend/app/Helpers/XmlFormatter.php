<?php

namespace App\Helpers;

use DOMDocument;
use \Illuminate\Support\Facades\Log;

class XmlFormatter
{
	public static function format($xmlString)
	{
		libxml_use_internal_errors(true);
		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;
		if (!$doc->loadxml($xmlString)) {
			$errors = libxml_get_errors();
			var_dump($errors);
		}

		$doc->loadXML($xmlString);
		return $doc->saveXML();
	}
}
