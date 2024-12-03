<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptAuthor extends Pivot
{
    protected $table = "ms_manuscript_author_roles";

    public function manuscript()
    {
        return $this->hasOne(Manuscript::class, "id", "manuscript_id");
    }
}
