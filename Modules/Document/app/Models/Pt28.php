<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Document\Database\Factories\Pt28Factory;
use Modules\AuditLog\Models\AuditLog;

class Pt28 extends Model
{
    use HasFactory;

    protected $table = 'pt28';

    protected $fillable = [
        'document_no',
        'issue_date',
        'branch_id',
        'pt28_id',
        'patient_id',
        'license_no',
        'dosage',
        'flower_unit',
        'objective',
        'pdf_path',
    ];



    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }

    public function details()
    {
        return $this->hasMany(
            Pt28Detail::class,
            'pt28_id'
        );
    }
}
