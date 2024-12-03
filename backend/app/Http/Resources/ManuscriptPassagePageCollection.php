<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ManuscriptPassagePageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection
            ->sortBy(['page.folio', 'page.seite'])
            ->groupBy('page.id')
            ->map(fn($mappings) => $mappings->first())
            ->sortBy(function ($mapping) {
                if (isset($mapping->page->old_manuscript)) {
                    return $mapping->page->old_manuscript->Kodextitel;
                }
                return $mapping->page->manuscript->title();
            })
            ->groupBy(function ($mapping) {
                if (isset($mapping->page->old_manuscript)) {
                    return $mapping->page->old_manuscript->ID;
                }
                return $mapping->page->manuscript->id;

            })
            ->map(function ($mappings) {
                $page = $mappings[0]->page;
                if (isset($page->old_manuscript)) {
                    $old_manuscript = $page->old_manuscript;
                    $manuscript_id = $old_manuscript->ID;
                    $manuscript_title = $old_manuscript->Kodextitel;
                    $archive = $old_manuscript->archive;
                } else {
                    $manuscript_id = $page->manuscript->id;
                    $manuscript_title = $page->manuscript->title();
                    $archive = $page->manuscript->archive;
                }


                return [
                    'manuscript_id' => $manuscript_id,
                    'title' => $manuscript_title,
                    'archive' => new ArchiveSummary($archive),
                    'pages' => $mappings->map(function ($entry) {
                        $page = $entry->page;
                        return [
                            'id' => $page->id,
                            'folio' => $page->folio,
                            'side' => $page->page_side,
                            'images' => new ManuscriptImageCollection($page->images, false),
                        ];
                    })

                ];
            });
    }
}
