<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pt28_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pt28_id')
                ->constrained('pt28')
                ->cascadeOnDelete();

            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patient')
                ->nullOnDelete();

            $table->date('issue_date')->nullable();

            $table->string('license_no')->nullable();

            $table->decimal('dosage', 10, 2)->default(0);

            $table->string('flower_unit')->default('กรัม');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pt28_details');
    }
};
