<?php

namespace Modules\AuditLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Branchs\Models\Branchs;

class AuditLog extends Model
{
    use HasFactory;


    protected $table = 'audit_logs';


    protected $fillable = [

        'user_id',
        'branch_id',

        'action',

        'auditable_type',
        'auditable_id',

        'description',
        'ip_address',

        'old_values',
        'new_values',

    ];


    /**
     * ผู้ใช้งานที่ทำรายการ
     */
    public function user()
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'user_id'
        );
    }

    public function branch()
    {
        return $this->belongsTo(
            \Modules\Branchs\Models\Branchs::class,
            'branch_id'
        );
    }


    /**
     * ข้อมูลที่ถูกกระทำ
     *
     * Patient
     * Document
     * PT33
     * PT28
     * Medics
     */
    public function auditable()
    {
        return $this->morphTo();
    }

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
