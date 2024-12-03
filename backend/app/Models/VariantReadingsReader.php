<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantReadingsReader extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.lc_leser';
}
