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
            $table->foreignId('branchs_id')
                ->constrained('branches')
                ->cascadeOnDelete();


            $table->foreignId('patient_id')
                ->constrained('patient')
                ->cascadeOnDelete();

            $table->foreignId('medic_id')
                ->nullable()
                ->constrained('medics')
                ->nullOnDelete();


            $table->date('visit_date');

            $table->text('note')->nullable();


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
