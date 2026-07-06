<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Document\Database\Factories\Pt33Factory;

class pt33 extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'p_id',
        'document_id',
        'title',
        'head',
        'day',
        'occupation',
        'certificate',
        'diagnose',
        'other',
        'cannabis_dosage',
        'cannabis_use_days',
        'cannabis_dosage_unit',
    ];
    protected $table = 'pt33';

    // protected static function newFactory(): Pt33Factory
    // {
    //     // return Pt33Factory::new();
    // }
}
