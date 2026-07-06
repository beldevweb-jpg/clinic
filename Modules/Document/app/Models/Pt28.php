<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Document\Database\Factories\Pt28Factory;

class pt28 extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['p_id', 'document_id', 'title', 'date', 'clinic_name', 'objective', 'license', 'dosage'];
    protected $table = 'pt28';

    


    // protected static function newFactory(): Pt28Factory
    // {
    //     // return Pt28Factory::new();
    // }
}
