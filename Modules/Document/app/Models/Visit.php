<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Medics\Models\medics;
use Modules\Patient\Models\patient;

class Visit extends Model
{
    protected $fillable = [
        'patient_id',
        'visit_no',
        'visit_date',
        'medic_id',
        'symptom',
        'diagnosis',
        'note',
        'created_by',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function medic()
    {
        return $this->belongsTo(Medics::class, 'medic_id');
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
