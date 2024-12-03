<?php

namespace App\Helpers;

class Range
{
	public $start;
	public $end;

	function __construct($start, $end)
	{
		$this->start = $start;
		$this->end = $end;
	}
}
