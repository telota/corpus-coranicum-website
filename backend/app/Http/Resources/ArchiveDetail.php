<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArchiveDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $description = null;
        if (isset($this->description)) {
            $lang = $request->language;
            if (empty($this->description->$lang)) {
                if (empty($this->description->en)) {
                    $description = $this->description->de;
                } else {
                    $description = $this->description->en;
                }
            } else {
                $description = $this->description->$lang;
            }


        }

        $title_begin = $this->place . ", " . $this->place_name;

        $manuscripts = $this->manuscripts->map(function ($m) use ($title_begin) {
            return [
                'id' => $m->id,
                'title' => $m->title ?? $title_begin . ": " . $m->call_number,
                'page' => $m->folio . $m->page_side,
                'sura' => $m->sura_start,
                'verse' => $m->verse_start,
            ];
        })->sortBy('title')->values();

        return [
            "id" => $this->id,
            "city" => $this->place,
            "country_code" => $this->country_code,
            "name" => $this->place_name,
            "link" => $this->link,
            "description" => $description,
            "image" => $this->image_link,
            "image_description" => $this->image_description,
            "image_link" => $this->image_link,
            "manuscripts" =>$manuscripts,
        ];
    }
}
