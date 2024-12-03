<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ManuscriptImageCollection extends ResourceCollection
{
    private $detailed;

    private function digilib_iiif_path($normalPath)
    {
        $parsed = pathinfo($normalPath);
        return config('cc_config.digilib.iiif')
            . str_replace('/', '!', $parsed['dirname'])
            . '!'
            . $parsed['filename']
            . '/info.json';
    }

    public function __construct($resource, $detailed)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->detailed = $detailed ?? false;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $imageResolution = $this->detailed ?
            config('cc_config.digilib.width_parameter') : config('cc_config.digilib.thumbnail');


        return $this->collection->map(function ($image) use ($imageResolution) {
            if (isset($image->image_link)) {
                $image_url = (config('cc_config.digilib.base') .
                    $image->image_link . $imageResolution);
                $iiif_url = $this->digilib_iiif_path($image->image_link);
            } else {
                $image_url = $image->thumbnail_external;
                $iiif_url = $image->iiif_external;
            }

            if($image->credit_line_image === null || trim($image->credit_line_image) === ""){
                $source = $image->manuscriptpage->manuscript->credit_line_image;
            }else{
                $source = $image->credit_line_image;
            }

            return [
                'id' => $image->id,
                'image_url' => $image_url,
                'iiif_url' => $iiif_url,
                'image_source' => $source,
                'external_url' => $image->image_link_external,
            ];
        });
    }
}
