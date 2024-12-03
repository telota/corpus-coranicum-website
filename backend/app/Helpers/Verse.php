<?php

namespace App\Helpers;

use \Illuminate\Support\Facades\Log;

class Verse
{

	public $sura;
	public $verse;

	function __construct($sura, $verse)
	{
		$this->sura = $sura;
		$this->verse = $verse;
	}

	public function isGreaterThan(Verse $verse)
	{
		if ($this->sura > $verse->sura) {
			return true;
		}
		if ($this->sura == $verse->sura) {
			return $this->verse > $verse->verse;
		}
		return false;
	}
	public static function minByVerse($elements)
	{
		return Verse::minOrMaxByVerse($elements, true);
	}
	public static function maxByVerse($elements)
	{
		return Verse::minOrMaxByVerse($elements, false);
	}


	private static function minOrMaxByVerse($elements, $findMin)
	{
		$minimum = $elements[0];

		foreach ($elements as $el) {
			$current = new Verse($minimum->sura, $minimum->verse);
			$next = new Verse($el->sura, $el->verse);

			//Replace with current element if we are finding the min and it is less 
			if ($findMin && ($current->isGreaterThan($next))) {
				$minimum = $el;
			}
			//Replace with current element if we are finding the max and it more or equal 
			if (!$findMin && !$current->isGreaterThan($next)) {
				$minimum = $el;
			}
		}
		return $minimum;
	}
}
