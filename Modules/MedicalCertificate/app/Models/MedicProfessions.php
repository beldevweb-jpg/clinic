<?php

namespace Modules\MedicalCertificate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'medics_id',
    ];


    public function patient()
    {
        return $this->belongsTo(
            Patient::class
        );
    }


    public function medic()
    {
        return $this->belongsTo(
            Medic::class,
            'medics_id'
        );
    }
}
