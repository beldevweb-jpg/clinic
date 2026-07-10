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
        Schema::create('pt28', function (Blueprint $table) {

            $table->id();


            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->foreignId('visit_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->string('document_id');


            $table->date('issue_date');


            $table->text('objective')
                ->nullable();


            $table->foreignId('medic_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->decimal('dosage', 10, 2)
                ->nullable();


            $table->string('flower_unit')
                ->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt28');
    }
};
