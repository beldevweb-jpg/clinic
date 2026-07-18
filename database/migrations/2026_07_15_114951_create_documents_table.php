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
        Schema::create('documents', function (Blueprint $table) {

            $table->id();


            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patient')
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->constrained('branches')
                ->cascadeOnDelete();

            $table->string('document_no')
                ->unique();


            $table->enum('type', [
                'pt28',
                'MedicalCertificate',
                'pt33'
            ]);
            $table->string('pdf_path')->nullable();
            $table->date('document_date')->default(now());
            $table->enum('status', [
                'draft',
                'completed',
                'cancelled'
            ])->default('draft');


            $table->foreignId('created_by')
                ->constrained('user')
                ->cascadeOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
