<?php

namespace Modules\Medics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Medics\Database\Factories\MedicsFactory;
use Modules\AuditLog\Models\AuditLog;

use Illuminate\Database\Eloquent\Relations\HasMany;

class medics extends Model
{
    use HasFactory;

    protected $table = 'medics';

    protected $fillable = [
        'prefix',
        'firstname',
        'lastname',
        'phone',
        'license',
        'signature',
        'status',
    ];



    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }

    public function professions()
    {
        return $this->hasMany(MedicProfessions::class, 'medic_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
