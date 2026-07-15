<?php

namespace Modules\Medics\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AuditLog\Models\AuditLog;


class MedicProfessions extends Model
{
    protected $table = 'medic_professions';

    protected $fillable = [
        'medic_id',
        'profession_id',
    ];

    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }

    public function profession()
    {
        return $this->belongsTo(
            Professions::class,
            'profession_id'
        );
    }


    public function medic()
    {
        return $this->belongsTo(
            medics::class,
            'medic_id'
        );
    }
}
