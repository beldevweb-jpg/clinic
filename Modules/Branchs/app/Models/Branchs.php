<?php

namespace Modules\Branchs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Visits\Models\Visits;
use Modules\AuditLog\Models\AuditLog;


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

    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }

    public function visits()
    {
        return $this->hasMany(
            Visits::class,
            'branch_id'
        );
    }
}
