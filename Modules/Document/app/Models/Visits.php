<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Medics\Models\medics;
use Modules\Patient\Models\patient;
use Modules\Branchs\Models\Branchs;
use Modules\AuditLog\Models\AuditLog;

class Visits extends Model
{
    protected $fillable = [
        'branch_id',
        'patient_id',
        'medic_id',
        'visit_date',
        'note',
    ];

    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function medic()
    {
        return $this->belongsTo(Medics::class, 'medic_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branchs::class, 'branch_id');
    }
}
