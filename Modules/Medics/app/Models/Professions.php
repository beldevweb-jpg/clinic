<?php

namespace Modules\Medics\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AuditLog\Models\AuditLog;


class Professions extends Model
{

    protected $table = 'professions';


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


    public function medics()
    {
        return $this->belongsToMany(
            Medics::class,
            'medic_professions',
            'profession_id',
            'medic_id'
        );
    }

}