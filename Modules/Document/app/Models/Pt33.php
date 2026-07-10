<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\patient;
use Modules\Medics\Models\medics;
// use Modules\Document\Database\Factories\Pt33Factory;

class pt33 extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'visit_id',
        'document_id',

        'document_no',
        'issue_date',
        'profession',

        'title',
        'head',
        'day',
        'occupation',
        'certificate',

        'diagnosis',
        'other',

        'cannabis_dosage',
        'cannabis_use_days',
        'cannabis_dosage_unit',
    ];
    protected $table = 'pt33';

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function pt33()
    {
        return $this->hasOne(Pt33::class, 'document_no');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
    
}
