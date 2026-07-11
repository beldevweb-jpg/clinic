<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pt28', function (Blueprint $table) {

            // ลบ foreign key ก่อน
            $table->dropForeign(['patient_id']);

            // แล้วค่อยลบ column
            $table->dropColumn('patient_id');
        });
    }


    public function down(): void
    {
        Schema::table('pt28', function (Blueprint $table) {

            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patients');
        });
    }
};
