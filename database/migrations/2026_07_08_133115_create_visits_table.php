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


            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->string('visit_no');


            $table->date('visit_date');


            $table->foreignId('medic_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->text('symptom')
                ->nullable();


            $table->text('diagnosis')
                ->nullable();


            $table->text('note')
                ->nullable();


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
