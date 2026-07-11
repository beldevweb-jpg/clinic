<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pt28Detail extends Model
{
    use HasFactory;

    protected $table = 'pt28_details';

    protected $fillable = [
        'pt28_id',
        'patient_id',
        'issue_date',
        'license_no',
        'dosage',
        'flower_unit',
    ];


    public function pt28()
    {
        return $this->belongsTo(
            Pt28::class,
            'pt28_id'
        );
    }


    public function patient()
    {
        return $this->belongsTo(
            \Modules\Patient\Models\Patient::class,
            'patient_id'
        );
    }
}
