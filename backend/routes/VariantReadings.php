<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VariantReadings;


Route::get(
	'/data/variants/canonical',
	[VariantReadings::class, 'canonicalReaders']
);

Route::get(
	'/data/variants/sura/{sura}/verse/{verse}',
	[VariantReadings::class, 'getVariantsByVerse']
);
