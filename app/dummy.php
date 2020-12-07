<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dummy extends Model
{
    protected $table = 'dummy';
    protected $fillable = [
        'image'
    ];
}
