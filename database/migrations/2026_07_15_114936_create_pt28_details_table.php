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
        Schema::create('pt28_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patient')
                ->cascadeOnDelete();
                
            $table->foreignId('pt28_id')
                ->constrained('pt28')
                ->cascadeOnDelete();

            $table->string('license_no')
                ->nullable();

            $table->decimal('dosage', 10, 2)
                ->default(0);

            $table->longText('objective')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt28_details');
    }
};
