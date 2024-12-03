<?php

namespace App\Helpers;

use App\Exceptions\VerseDoesNotExist;

class VerseFunctions
{

	public static function ExceptionIfInvalidVerse(Verse $v, $verse_counts)
	{
		if (!self::VerseExists($v, $verse_counts)) {
			throw new VerseDoesNotExist("For sura {$v->sura}, verse {$v->verse}.");
		}
	}

	public static function VerseExists(Verse $v, $verse_counts)
	{
		$sura = $v->sura;
		$verse = $v->verse;

		if (array_key_exists($sura, $verse_counts)) {
			return ($sura > 0 && $verse <= $verse_counts[$sura]);
		}
		return false;
	}


	public static function NextVerse(Verse $v, $verse_counts)
	{
		$sura = $v->sura;
		$verse = $v->verse;

		self::ExceptionIfInvalidVerse($v, $verse_counts);

		if ($verse == $verse_counts[$sura]) {
			if (array_key_exists($sura + 1, $verse_counts)) {
				return new Verse($sura + 1, 1);
			};
			return null;
		}
		return new Verse($sura, $verse + 1);
	}
}
