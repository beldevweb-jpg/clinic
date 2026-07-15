<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {

            $table->id();


            /**
             * คนที่ทำรายการ
             */
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('user')
                ->nullOnDelete();


            /**
             * CREATE UPDATE DELETE PRINT
             */
            $table->string('action');


            /**
             * Target Model
             * เช่น
             * Modules\Patient\Models\patient
             * Modules\Document\Models\Document
             */
            $table->string('auditable_type');


            /**
             * ID ของ Model นั้น
             */
            $table->unsignedBigInteger('auditable_id');


            $table->text('description')
                ->nullable();


            $table->ipAddress('ip_address')
                ->nullable();


            $table->timestamps();


            /**
             * เพิ่ม index ให้ค้นหาเร็ว
             */
            $table->index([
                'auditable_type',
                'auditable_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
