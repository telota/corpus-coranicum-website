<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptImageTmpLink extends Model
{
    use HasFactory;
    protected $fillable = ["uuid","image_id"];
    protected $table = 'corpuscoranicum.ms_image_tmp_link';
    public $timestamps = false;

    public function image(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ManuscriptImage::class,"id","image_id");
    }
}
