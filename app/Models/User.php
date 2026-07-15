<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Roles;
use App\Models\Branch;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $table = 'user';


    protected $fillable = [
        'name',
        'username',
        'password',
        'branch_id',
        'active',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }


    public function roles()
    {
        return $this->belongsToMany(
            Roles::class,
            'role_user',
            'user_id',
            'role_id'
        );
    }


    public function hasRole($role)
    {
        return $this->roles()
            ->where('slug', $role)
            ->exists();
    }


    public function branch()
    {
        return $this->belongsTo(
            Branch::class,
            'branch_id'
        );
    }
}