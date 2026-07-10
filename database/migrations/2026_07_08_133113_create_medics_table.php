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
        Schema::create('medics', function (Blueprint $table) {

            $table->id();


            $table->foreignId('professions_id')
                ->constrained('professions')
                ->cascadeOnDelete();


            $table->string('prefix')->nullable();

            $table->string('firstname');

            $table->string('lastname');


            // เลขใบประกอบวิชาชีพ
            $table->string('license')
                ->unique();


            $table->string('phone')
                ->nullable();


            // รูปลายเซ็น
            $table->string('signature')
                ->nullable();


            // เปิด/ปิดใช้งาน
            $table->boolean('status')
                ->default(true);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medics');
    }
};
