<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;

class SubUser extends Authenticatable
{
    use CanResetPassword, Notifiable;

    protected $table = 'subusers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'last_activity_at',
        'session_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    /**
     * Subser belongs to a single role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
