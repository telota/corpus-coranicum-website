<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrintedEditionController;

Route::get(
	'/data/language/{language}/concordance-relation/sura/{sura}/verse/{verse}',
	[PrintedEditionController::class, 'concordance']
);
Route::get(
	'/data/language/{language}/print-edition/sura/{sura}/verse/{verse}',
	[PrintedEditionController::class, 'data']
);
