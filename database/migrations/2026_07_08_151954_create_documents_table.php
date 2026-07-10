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

            // คนไข้เจ้าของเอกสาร
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            // เลขเอกสาร เช่น PT33-000001
            $table->string('document_no')
                ->unique();

            // ประเภทเอกสาร PT33, PT28, CERTIFICATE
            $table->string('type');

            // สถานะเอกสาร
            // draft, completed, cancelled
            $table->enum('status', [
                'draft',
                'completed',
                'cancelled'
            ])->default('draft');

            // ผู้สร้างเอกสาร
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

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
