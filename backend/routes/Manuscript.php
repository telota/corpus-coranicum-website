<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManuscriptsController;


Route::get(
	'/data/manuscripts/all',
	[ManuscriptsController::class, 'getAllManuscripts']
);

Route::get(
	'/data/language/{language}/manuscripts/archives',
	[ManuscriptsController::class, 'getAllArchivesAndManuscripts']
);
Route::get(
	'/data/language/{language}/manuscripts/archives/new',
	[ManuscriptsController::class, 'getAllArchivesAndManuscriptsNew']
);

Route::get(
	'/data/manuscripts/sura/{sura}/verse/{verse}',
	[ManuscriptsController::class, 'getPagesForVerse']
);

Route::get(
	'/data/manuscripts/{id}',
	[ManuscriptsController::class, 'getManuscript']
);

Route::get(
	'/data/language/{language}/manuscripts/{id}/pages/{folio_and_side}',
	[ManuscriptsController::class, 'getPage']
);
