<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCRole extends Model
{
    use HasFactory;
    protected $table = "cc_roles";
    public function module()
    {
        return $this->hasOne(Module::class, 'id', 'module_id');
    }

    public function authors()
    {
        return $this->hasMany(CCAuthorRole::class, 'role_id', 'id');
    }
}
