<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntertextCategories extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.belegstellen_kategorie';
    public function subCategories()
    {
        return $this->hasMany('App\Models\IntertextCategories', 'supercategory', 'id');
    }
}
