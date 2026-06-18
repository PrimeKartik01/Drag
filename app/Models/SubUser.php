<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;

class SubUser extends Authenticatable
{
    use CanResetPassword;

    protected $table = 'subusers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'designation',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];
}
