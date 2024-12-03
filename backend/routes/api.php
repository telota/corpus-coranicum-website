<?php

use App\Models\CollegiumCoranicum;
use App\Models\Event;
use App\Models\ManuscriptImage;
use App\Models\ManuscriptImageTmpLink;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

include('Commentary.php');
include('Concordance.php');
include('Intertext.php');
include('Manuscript.php');
include('PrintEdition.php');
include('Quran.php');
include('Translations.php');
include('VariantReadings.php');
Route::get(
    '/website/collegium-coranicum',
    function () {
        return CollegiumCoranicum::fetchAll();
    }
);
Route::get(
    '/website/events',
    function () {
        return Event::fetchAll();
    }
);
Route::get('/irankoran/image/{id}', function ($id, Request $request) {
    $token = $request->bearerToken();
    if ($token !== env('IMAGES_API_KEY')) {
        abort(401);
    }

    $image = ManuscriptImage::findOrFail($id);
    $tmp = ManuscriptImageTmpLink::create([
        'uuid' => Uuid::uuid4(),
        'image_id' => $image->id,
    ]);
    return $tmp->uuid;
});

Route::get('/image/{uuid}', function ($uuid, Request $request) {
    $tmpLink = ManuscriptImageTmpLink::where('uuid', $uuid)
        ->where('created_at', ">=", Carbon::now()->subMinutes(15)->toDateTimeString())
        ->with('image')
        ->firstOrFail();

    $width = $request->get("width");
    $digilib_width = $width ? "&dw=$width" : config('cc_config.digilib.width_parameter');

    return redirect(config('cc_config.digilib.base') . $tmpLink->image->image_link . $digilib_width);
});

