<?php

namespace App\Helpers;


class Utilities
{

	public static function stringOrNull($string)
	{
		if (trim(strip_tags($string)) != '') {
			return $string;
		}
		return null;
	}

	public static function hasStringKeys(array $array) {
		return count(array_filter(array_keys($array), 'is_string')) > 0;
	}
}
