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

            $table->string('firstname');
            $table->string('lastname');
            $table->string('firstname_en');
            $table->string('lastname_en');

            $table->date('birthday')->nullable();

            $table->string('gender')->nullable();

            // ข้อมูล Smart Card
            $table->text('card_address')->nullable();

            // ที่อยู่
            $table->string('subdistrict')->nullable(); // ตำบล

            $table->string('district')->nullable();    // อำเภอ

            $table->string('province')->nullable();    // จังหวัด

            $table->string('zipcode', 5)->nullable();  // รหัสไปรษณีย์

            // ติดต่อ
            $table->string('phone')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient ');
    }
};
