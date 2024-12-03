<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\InfoPage;


Route::get(
	'/language/{language}/translations',
	[TranslationsController::class, 'shortTranslations']
);

Route::get(
	'/website/language/{language}/{category}',
	[TranslationsController::class, 'website']
);

Route::get(
	'/{language}/pages/{page}',
	[TranslationsController::class, 'pages']
);

Route::get(
	'/website/language/{language}/info/{website}',
	[InfoPage::class, 'getPage']
);