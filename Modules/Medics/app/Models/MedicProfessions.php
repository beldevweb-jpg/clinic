<?php

namespace Modules\Medics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Medics\Database\Factories\MedicProfessionsFactory;

class MedicProfessions extends Model
{
    protected $table = 'medic_professions';

    protected $fillable = [
        'medic_id',
        'professions_id',
    ];


    public function profession()
    {
        return $this->belongsTo(Professions::class, 'professions_id');
    }
}
