<?php

namespace App\EloquentBuilders;

use Illuminate\Database\Eloquent\Builder;

class EloquentBuilder extends Builder
{
    public function published(): self
    {
        return $this->where(function ($query) {
            $query->where('is_online', true);
        });
    }

    public function imagePagePublished(): self
    {
        return $this->where('is_online', true);
    }

    public function imagePublished(): self
    {
        return $this->where('private_use_only', false);
    }
}
