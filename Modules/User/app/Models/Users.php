<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\User\Database\Factories\UserFactory;

class Users extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'status',
    ];
    protected $table = 'users';

    // protected static function newFactory(): UserFactory
    // {
    //     // return UserFactory::new();
    // }
}
