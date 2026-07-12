<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Document\Models\pt33;
use Modules\Document\Models\Document;
use Modules\Document\Models\Visit;

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

        // Smart Card
        'firstname_en',
        'lastname_en',
        'card_issue_date',
        'card_expire_date',
        'card_photo',

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


    public function visits()
    {
        return $this->hasMany(Visit::class, 'patient_id');
    }
}
