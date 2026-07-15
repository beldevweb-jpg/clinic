<?php

namespace Modules\AuditLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class AuditLog extends Model
{
    use HasFactory;


    protected $table = 'audit_logs';


    protected $fillable = [
        'user_id',
        'action',
        'table_name',
        'record_id',
        'description',
        'ip_address',
    ];


    /**
     * ผู้ใช้งานที่ทำรายการ
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /**
     * ข้อมูลที่ถูกกระทำ
     * เช่น Patient, Document, PT33
     */
    public function record()
    {
        return $this->morphTo(
            null,
            'table_name',
            'record_id'
        );
    }
}
