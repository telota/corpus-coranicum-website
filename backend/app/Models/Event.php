<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'corpuscoranicum.veranstaltungen';

    public static $fields = [
        "titel as title",
        "datum_start as start",
        "datum_ende as end",
        "ort as location",
        "beschreibung as description",
    ];

    public static function fetchAll()
    {
        return Event::select(Event::$fields)
            ->orderby('start','DESC')
            ->get();
    }
}
