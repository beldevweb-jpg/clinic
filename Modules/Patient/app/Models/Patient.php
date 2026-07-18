<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Document\Models\pt33;
use Modules\Document\Models\Document;
use Modules\Document\Models\Visits;
use Modules\AuditLog\Models\AuditLog;

// use Modules\Patient\Database\Factories\PatientFactory;

class patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'patient';

    protected $fillable = [

        'hn',
        'cid',

        'title',
        'prefix',
        'firstname',
        'lastname',

        'firstname_en',
        'lastname_en',

        'nationality',

        'age',
        'birthday',
        'gender',

        'card_address',
        'subdistrict',
        'district',
        'province',
        'zipcode',

        'phone',

        'blood_pressure',
        'pulse_rate',
        'respiratory_rate',
        'temperature',

        'height',
        'weight',

        'chief_complaint',
        'physical_exam',
        'diagnosis',
        'treatment',

    ];

    public function pt33s()
    {
        return $this->hasMany(Pt33::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }


    public function visits()
    {
        return $this->hasMany(Visits::class, 'patient_id');
    }



    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }
}
