<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IntertextImage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'url' => config('cc_config.digilib.base') . ($this->bildlink) . config('cc_config.digilib.width_parameter'),
            'credits' => $this->bildnachweis
        ];
    }
}
