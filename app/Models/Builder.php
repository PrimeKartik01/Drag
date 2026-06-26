<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Builder extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'photo',
        'description',
        'rera_no'
    ];
}
