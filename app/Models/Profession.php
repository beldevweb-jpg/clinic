<?php

namespace App\Models;

use Modules\AuditLog\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    protected $fillable = [
        'name',
    ];


    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }
}
