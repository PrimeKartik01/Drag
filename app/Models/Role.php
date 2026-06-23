<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name',  'description'];

    /**
     * Roles belongs to many permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission')->withPivot('table_name');
    }

    /**
     * A role can belongs to many subusers
     */
    public function subusers()
    {
        return $this->hasMany(SubUser::class);
    }
}
