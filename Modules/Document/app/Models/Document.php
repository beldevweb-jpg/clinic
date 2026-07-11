<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\MedicalCertificate\Models\MedicalCertificate;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'patient_id',
        'document_no',
        'type',
        'status',
        'pdf_path',
        'document_date',
        'created_by',
    ];


    protected $casts = [
        'document_date' => 'date',
    ];


    public function patient()
    {
        return $this->belongsTo(
            \Modules\Patient\Models\Patient::class,
            'patient_id'
        );
    }


    public function creator()
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'created_by'
        );
    }

    public function pt33()
    {
        return $this->hasOne(
            Pt33::class,
            'document_no',
            'document_no'
        );
    }

    public function pt28()
    {
        return $this->hasOne(
            Pt28::class,
            'document_no',
            'document_no'
        );
    }

    public function medicalCertificate()
    {
        return $this->hasOne(
            MedicalCertificate::class,
            'document_no',
            'document_no'
        );
    }
}
