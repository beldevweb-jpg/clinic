<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Document\Database\Factories\Pt28Factory;

class Pt28 extends Model
{
    use HasFactory;

    protected $table = 'pt28';

    protected $fillable = [
        'document_no',
        'issue_date',
        'objective',
    ];

    public function details()
    {
        return $this->hasMany(
            Pt28Detail::class,
            'pt28_id'
        );
    }
}
