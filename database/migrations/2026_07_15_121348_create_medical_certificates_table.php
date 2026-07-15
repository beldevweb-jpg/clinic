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
        Schema::create('medical_certificates', function (Blueprint $table) {

            $table->id();


            $table->string('document_no')
                ->unique();


            $table->date('certificate_date');


            $table->foreignId('patient_id')
                ->constrained('patient')
                ->cascadeOnDelete();


            $table->foreignId('medic_id')
                ->constrained('medics')
                ->cascadeOnDelete();


            $table->text('symptom')
                ->nullable();



            $table->integer('rest_days')
                ->default(0);


            $table->string('pdf_path')
                ->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_certificates');
    }
};
