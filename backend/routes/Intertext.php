<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Intertext;
use App\Http\Controllers\IntertextStatistics;

Route::get(
	'data/intertexts',
	[Intertext::class, 'getAllIntertexts']
);

Route::get(
	'/data/intertexts/{id}',
	[Intertext::class, 'getIntertext']
);

Route::get(
	'/data/intertexts/count-per-verse',
	[IntertextStatistics::class, 'CountPerVerse']
);

Route::get(
	'/data/intertexts/sura/{sura}/verse/{verse}',
	[Intertext::class, 'getIntertextsByVerse']
);
