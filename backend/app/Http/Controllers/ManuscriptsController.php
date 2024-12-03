<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArchiveDetail;
use App\Http\Resources\ManuscriptDetail;
use App\Http\Resources\OldManuscriptDetail;
use App\Http\Resources\ManuscriptPageDetail;
use App\Http\Resources\ManuscriptPassagePageCollection;
use App\Models\Manuscript;
use App\Models\ManuscriptPage;
use App\Models\ManuscriptPagePassage;
use App\Models\ManuscriptRepository;
use App\Models\OldManuscript;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ManuscriptsController extends Controller
{
    public function getAllArchivesAndManuscripts($language)
    {
        $places = ManuscriptRepository::with('description')
            ->orderBy('place')
            ->orderBy('place_name')
            ->get()
            ->keyBy('id');

        $ms = DB::table('ms_manuscript as m')
            ->leftJoin('ms_manuscript_pages as p', 'm.id', 'p.manuscript_id')
            ->leftJoin('ms_manuscript_pages_mapping as map', 'p.id', 'map.manuscript_page_id')
            ->select('m.id', 'm.place_id', 'm.call_number', 'p.folio', 'p.page_side', 'map.sura_start', 'map.verse_start')
            ->where('m.is_online', true)
            ->get();

        $new_ms = $ms->groupBy('id')->map->first()->keyBy('id');


        $ms = DB::table('manuskript as m')
            ->leftJoin('ms_manuscript_pages as p', 'm.id', 'p.manuscript_id')
            ->leftJoin('ms_manuscript_pages_mapping as map', 'p.id', 'map.manuscript_page_id')
            ->select('m.ID as id', 'm.place_id', 'm.Kodextitel as title', 'p.folio', 'p.page_side', 'map.sura_start', 'map.verse_start')
            ->where('m.webtauglich', 'ja')
            ->orWhere('m.webtauglich', 'ohneBild')
            ->get();

        $old_ms = $ms->groupBy('id')->map->first()->keyBy('id');

        $merged = $new_ms->union($old_ms);

        $ms_by_place = $merged->groupBy('place_id')->map(fn($ms) => ['manuscripts' => $ms]);

        $places_with_manuscripts = $places
            ->map(function ($place) use ($ms_by_place) {
                if (isset($ms_by_place[$place->id])) {
                    $place['manuscripts'] = $ms_by_place[$place->id]['manuscripts'];
                    return $place;
                }
            })
            ->filter(fn($place) => isset($place))
            ->values();

        return ArchiveDetail::collection($places_with_manuscripts);
    }

    public function getManuscript($id)
    {

        $m = Manuscript::where('ID', $id)
            ->published()
            ->with(
                'archive',
                'provenances',
                'authorRoles.role.module',
                'authorRoles.author',
                'pages.passages',
                'passages',
            )
            ->first();

        if (isset($m)) {
            return new ManuscriptDetail($m);
        }

        $old = OldManuscript::where('ID', $id)
            ->published()
            ->with(
                'archive',
                'passages',
                'pages:id,manuscript_id,folio,page_side',
                'pages.passages'
            )
            ->firstOrFail();

        return new OldManuscriptDetail($old);
    }

    public function getPagesForVerse($sura, $verse)
    {
        // ToDo: new manuscripts

        $query = ManuscriptPagePassage::suraAndVerse($sura, $verse)
            // This line is to exclude the front and backpages that are currently marked
            //  as only containing 001:001:000.
            ->where(DB::raw('word_end + sura_end + verse_end'), ">", 2)
            ->completeVerse()
            ->publishedPage()
            ->with([
                'page:id,folio,page_side,manuscript_id,is_online',
                'page.images',
                'page.manuscript.archive',
                'page.old_manuscript.archive',
                ])
            ->get();

        return new ManuscriptPassagePageCollection($query);
    }

    public function getPage($language, $manuscriptId, $folio_and_side)
    {
        $query = ManuscriptPage::where('manuscript_id', $manuscriptId)
            ->where(DB::raw("CONCAT_WS('',folio, page_side)"), $folio_and_side)
            ->publishedManuscript()
            ->published()
            ->with([
                'manuscript:id,is_online,transliteration_file',
                'old_manuscript:ID,webtauglich',
                'images.manuscriptpage.manuscript',
                'passages'
            ])
            ->firstOrFail();

        return new ManuscriptPageDetail($query);
    }

}
