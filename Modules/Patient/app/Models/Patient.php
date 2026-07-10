<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Document\Models\pt33;
use Modules\Document\Models\Document;
// use Modules\Patient\Database\Factories\PatientFactory;

class patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'patient';

    protected $fillable = [
        'hn',
        'cid',
        'prefix',
        'firstname',
        'lastname',
        'birthday',
        'age',
        'district',
        'subdistrict',
        'zipcode',
        'nationality',
        'province',
        'gender',
        'address',
        'phone',
        'email',
    ];

    public function pt33s()
    {
        return $this->hasMany(Pt33::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
