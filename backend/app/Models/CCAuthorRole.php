<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCAuthorRole extends Model
{
    use HasFactory;
    protected $table = "cc_author_roles";
    public function author(){
        return $this->belongsTo(CCAuthor::class,"author_id", "id");
    }

    public function role(){
        return $this->belongsTo(CCRole::class,"role_id", "id");
    }
}
