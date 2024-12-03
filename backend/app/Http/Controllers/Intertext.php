<?php

namespace App\Http\Controllers;

use App\Http\Resources\IntertextSummary;
use App\Http\Resources\IntertextDetail;
use App\Http\Resources\WithVersesCollection;
use App\Models\IntertextMapping;
use App\Models\Intertext as IntertextModel;

class Intertext extends Controller
{

    public function getAllIntertexts()
    {
        return new WithVersesCollection(IntertextModel::fetchAllIntertexts());
    }

    public function getIntertextsByVerse($sura, $verse)
    {
        return IntertextSummary::collection(
            IntertextMapping::getIntertextsForVerse($sura, $verse)
        );
    }

    public function getIntertext($id)
    {
        return new IntertextDetail(IntertextModel::fetchIntertext($id));
    }
}
