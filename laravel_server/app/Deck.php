<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'decks';

    protected $fillable = [
        'name',
        'active',
        'complete',
        'hidden_face_image_path'
    ];

}
