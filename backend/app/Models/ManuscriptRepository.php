<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptRepository extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.ms_places';

    public function description(){
        return $this->belongsTo(Translation::class,'description_id');
    }
}
