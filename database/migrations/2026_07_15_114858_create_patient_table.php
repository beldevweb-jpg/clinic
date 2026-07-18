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
        Schema::create('patient', function (Blueprint $table) {

            $table->id();

            // HN
            $table->string('hn')->unique();

            // เลขบัตรประชาชน
            $table->string('cid', 13)
                ->nullable()
                ->unique();

            // ข้อมูลส่วนตัว
            $table->string('title')->nullable();
            $table->string('prefix');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('firstname_en');
            $table->string('lastname_en');
            $table->string('nationality');
            $table->integer('age');
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();

            // ข้อมูล Smart Card
            $table->text('card_address')->nullable();

            // ที่อยู่
            $table->string('subdistrict')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode', 5)->nullable();

            // ติดต่อ
            $table->string('phone')->nullable();

            // ==========================
            // ข้อมูลสุขภาพเบื้องต้น
            // ==========================

            $table->string('blood_pressure')->nullable();      // 130/80
            $table->integer('pulse_rate')->nullable();         // PR
            $table->integer('respiratory_rate')->nullable();   // RR
            $table->decimal('temperature', 4, 1)->nullable();  // T
            $table->decimal('height', 5, 2)->nullable();       // cm
            $table->decimal('weight', 5, 2)->nullable();       // kg

            // ==========================
            // ข้อมูลการรักษา
            // ==========================

            $table->text('chief_complaint')->nullable();   // อาการสำคัญ
            $table->text('physical_exam')->nullable();     // ตรวจอื่น ๆ
            $table->text('diagnosis')->nullable();         // DX
            $table->text('treatment')->nullable();         // TX

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient');
    }
};
