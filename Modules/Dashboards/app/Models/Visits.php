<?php

namespace Modules\Dashboards\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Branchs;
use App\Models\Patient;
use App\Models\Medics;


class Visits extends Model
{
    use HasFactory;


    protected $table = 'visits';


    protected $fillable = [
        'branchs_id',
        'patient_id',
        'medic_id',
        'visit_date',
        'note',
    ];



    public function branch()
    {
        return $this->belongsTo(
            Branchs::class,
            'branchs_id'
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
