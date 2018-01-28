<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'config';

    protected $fillable = [
        'platform_id',
        'img_base_path'
    ];

}
