<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cards';

    protected $fillable = [
        'suite',
        'value',
        'deck_id',
        'path'
    ];

}
