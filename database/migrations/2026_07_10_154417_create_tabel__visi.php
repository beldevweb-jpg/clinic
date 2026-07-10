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
        Schema::create('visits', function (Blueprint $table) {

            $table->id();

            // ผู้ป่วย
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            // เลขที่ Visit
            $table->string('visit_no')->unique();

            // วันที่เข้ารับบริการ
            $table->date('visit_date');

            // แพทย์ผู้ตรวจ
            $table->foreignId('medic_id')
                ->constrained('medics')
                ->cascadeOnDelete();

            // อาการ
            $table->text('symptom')->nullable();

            // การวินิจฉัย
            $table->text('diagnosis')->nullable();

            // หมายเหตุ
            $table->text('note')->nullable();

            // ผู้บันทึกข้อมูล
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
