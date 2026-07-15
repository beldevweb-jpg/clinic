<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Patient\Database\Factories\HnFactory;
use Modules\AuditLog\Models\AuditLog;

class hn_running extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'hn_running';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    // protected static function newFactory(): HnFactory
    // {
    //     // return HnFactory::new();
    // }



    public function auditLogs()
    {
        return $this->morphMany(
            AuditLog::class,
            'auditable'
        );
    }
}
