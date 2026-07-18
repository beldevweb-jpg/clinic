<?php

namespace Modules\AuditLog\Observers;

use Modules\AuditLog\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditObserver
{

    /**
     * เมื่อสร้างข้อมูล
     */
    public function created($model)
    {
        $this->log(
            $model,
            'CREATE',
            'สร้างข้อมูล ' . class_basename($model)
        );
    }


    /**
     * เมื่อแก้ไขข้อมูล
     */
    public function updated($model)
    {
        $this->log(
            $model,
            'UPDATE',
            'แก้ไขข้อมูล ' . class_basename($model)
        );
    }


    /**
     * เมื่อลบข้อมูล
     */
    public function deleted($model)
    {
        $this->log(
            $model,
            'DELETE',
            'ลบข้อมูล ' . class_basename($model)
        );
    }


    private function log($model, $action, $description)
    {
        if (app()->runningInConsole()) {
            return;
        }


        $user = Auth::user();


        AuditLog::create([

            'user_id' => $user?->id,

            'branch_id' => $user?->branch_id,

            'action' => $action,

            'auditable_type' => get_class($model),

            'auditable_id' => $model->id,

            'description' => $description,

            'ip_address' => request()->ip(),

        ]);
    }
}
