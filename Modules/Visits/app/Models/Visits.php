<?php

namespace Modules\Visits\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\Medics;
use Modules\Branchs\Models\Branchs;
use Modules\AuditLog\Models\AuditLog;

class Visits extends Model
{
    protected $table = 'visits';


    protected $fillable = [
        'branch_id',
        'patient_id',
        'medic_id',
        'visit_date',
        'type',
        'note',
        'visit_no',
        'created_by',
    ];


    public function branch()
    {
        return $this->belongsTo(
            Branchs::class,
            'branch_id'
        );
    }


    public function patient()
    {
        return $this->belongsTo(
            Patient::class,
            'patient_id'
        );
    }


    public function medic()
    {
        return $this->belongsTo(
            Medics::class,
            'medic_id'
        );
    }


    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }
}
