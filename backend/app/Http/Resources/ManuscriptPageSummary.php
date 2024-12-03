<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManuscriptPageSummary extends JsonResource
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
            'page_id' => $this->id,
            'folio' => $this->folio,
            'side' => $this->page_side,
            'passages' => ManuscriptPassage::collection($this->passages),
        ];
    }
}
