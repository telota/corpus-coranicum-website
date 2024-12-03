<?php

namespace App\Helpers;

use App\Models\ZoteroBibliography;

class ZoteroToBibliography
{
    private static function extractZoteroIDs($htmlString)
    {
        $pattern = '/zotero.org\/groups\/corpuscoranicum_pub\/items\/itemKey\/([A-Z0-9]+)/';
        preg_match_all($pattern, $htmlString, $matches);
        return $matches[1];
    }
    public static function pickZoteroEntries(string $string)
    {
        $zoteroIDs = self::extractZoteroIDs($string);
        $zoteroLink = config('cc_config.zotero.link_item');
        $zotero = ZoteroBibliography::select('citation', 'zotero_key')
            ->whereIn('zotero_key', $zoteroIDs)
            ->orderBy('citation')
            ->get()
            ->map(function ($item) use ($zoteroLink) {
                $item->zotero_key = $zoteroLink . $item->zotero_key;
                return $item;
            })
            ->toArray();           
        return $zotero;
    }
}
