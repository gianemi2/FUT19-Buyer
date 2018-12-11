<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sbc extends Model
{

    protected $table = 'sbc';

    protected $fillable = [
        'name',
        'url',
        'bought',
        'squadCount',
        'percentages',
        'incrementBy'
    ];

    public $timestamps = true;
}
