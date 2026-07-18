<?php

namespace Modules\MedicalCertificate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\Medics;
use Modules\AuditLog\Models\AuditLog;

class MedicalCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_no',
        'certificate_date',
        'patient_id',
        'symptom',
        'treatment_recommendation',
        'rest_days',
        'medic_id',
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
}
