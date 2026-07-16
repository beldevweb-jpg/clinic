<?php

namespace Modules\Medics\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Medics\Models\Professions;

class MedicProfessions extends Model
{

    protected $table = 'medic_professions';


    protected $fillable = [
        'medic_id',
        'profession_id',
    ];


    public function medic()
    {
        return $this->belongsTo(
            Medics::class,
            'medic_id'
        );
    }


    public function profession()
    {
        return $this->belongsTo(
            Professions::class,
            'profession_id'
        );
    }

    
}
