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
        Schema::create('pt33', function (Blueprint $table) {

            $table->id();


            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->foreignId('visit_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->string('document_id');


            $table->date('issue_date');


            $table->string('profession')
                ->nullable();


            $table->text('certificate')
                ->nullable();

            $table->text('diagnosis')->nullable();


            $table->decimal('cannabis_dosage', 10, 2)
                ->nullable();


            $table->integer('cannabis_use_days')
                ->nullable();


            $table->string('cannabis_dosage_unit')
                ->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt33');
    }
};
