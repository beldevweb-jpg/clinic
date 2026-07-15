<?php

namespace Modules\Medics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Medics\Database\Factories\ProfessionsFactory;
use Modules\AuditLog\Models\AuditLog;

class Professions extends Model
{
    protected $table = 'professions';

    protected $fillable = [
        'name',
    ];



    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }

    public function medics()
    {
        return $this->hasMany(MedicProfessions::class, 'profession_id');
    }
}
