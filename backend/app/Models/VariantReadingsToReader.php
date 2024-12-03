<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantReadingsToReader extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.lc_leseart_leser';
}
