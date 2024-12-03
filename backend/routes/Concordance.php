<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcordanceController;


Route::get(
	'/data/language/{language}/concordance/sura/{sura}/verse/{verse}/word/{word}/',
	[ConcordanceController::class, 'data']
);

Route::get(
	'/data/concordance/references/{field}/{word}',
	[ConcordanceController::class, 'references']
);
