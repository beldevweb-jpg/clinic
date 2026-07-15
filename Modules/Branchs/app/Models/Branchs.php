<?php

namespace Modules\Branchs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branchs extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'code',
        'name',
        'address',
        'phone',
        'license',
        'active',
    ];
}
