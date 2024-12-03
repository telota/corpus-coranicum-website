<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Commentary;


Route::get(
	'/data/commentary/sura/{sura}',
	[Commentary::class, 'getCommentary']
);

Route::get(
	'/data/commentary/available',
	[Commentary::class, 'availableCommentaries']
);

Route::get(
	'/data/commentary/introduction/{name}',
	[Commentary::class, 'getIntroduction']
);