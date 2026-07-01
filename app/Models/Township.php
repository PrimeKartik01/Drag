<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    protected $fillable = [
        'builder_id',
        'city_id',
        'name',
        'slug',
        'location',
        'description',
        'rera_no',
        'status'
    ];

    /**
     * Township belongs to only one builder
     */
    public function builder()
    {
        return $this->belongsTo(Builder::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
