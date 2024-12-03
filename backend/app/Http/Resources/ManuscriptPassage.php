<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManuscriptPassage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'start' => [
                'sura' => $this->sura_start,
                'verse' => $this->verse_start,
                'word' => $this->word_start == 999 ? null : $this->word_start,
            ],
            'end' => [
                'sura' => $this->sura_end,
                'verse' => $this->verse_end,
                'word' => $this->word_end == 999 ? null : $this->word_end,
            ]
        ];
    }
}
