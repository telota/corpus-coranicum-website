<?php

namespace App\Helpers;

class VerseParser
{

	public static function parseVerse(string $str)
	{
		try{
		$split = explode(':', $str);
		if(!isset($split[0])){
			throw new \Exception('Null parse on parse Verse');
		}
		//TODO: Asserts don't throw exceptions, as I would like them to. -ML
		assert(isset($split[0]));
		$sura = intval($split[0]);
		assert(isset($split[1]));
		$verse = intval($split[1]);
		return new Verse($sura, $verse);
		}
		catch(\Exception $e){
			throw new \Exception("String '${str}' failed with exception: {$e}");
		}
	}

	public static function parseVerseRange(string $str)
	{ 
		$split = explode('-', $str);
		assert(count($split) == 1 | count($split) == 2);
		$start = self::parseVerse($split[0]);

		if (count($split) == 2) {
			$end = self::parseVerse($split[1]);
		} else {
			$end = $start;
		}
		return new Range($start, $end);
	}
}
