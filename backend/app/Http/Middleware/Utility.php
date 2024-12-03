<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class Utility
{

	// Note: this is a workaround, because $request->input('name') and $request->all()
	// do not behave as the docs suggest they should.
	// It requires that a variable is named by the path segment immediate prior,
	// e.g. /language/{language}, and not /data/{language}
	public static function getUrlVariable(Request $request, string $param)
	{

		$index = array_search($param, $request->segments());

		if ($index) {
			return ($request->segments())[$index + 1];
		}
		return null;
	}
}
