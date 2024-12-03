<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quran;


Route::get(
	'/init/quran',
	[Quran::class, 'getSuraSummaries']
);

Route::get(
	'/data/cairo-pages',
	[Quran::class, 'getCairoPages']
);

Route::get(
	'/data/language/{language}/quran/verses/start/{sura_start}/{verse_start}/end/{sura_end}/{verse_end}',
	[Quran::class, 'getVerses']
);
