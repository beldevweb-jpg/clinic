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



            $table->foreignId('branch_id')
                ->constrained('branches')
                ->cascadeOnDelete();

            $table->foreignId('medic_id')
                ->nullable()
                ->constrained('medics')
                ->nullOnDelete();

            $table->string('document_no')
                ->unique();

            $table->date('issue_date');


            // ไฟล์ PDF
            $table->string('pdf_path')
                ->nullable();


            $table->enum('status', [
                'draft',
                'completed',
                'cancelled'
            ])->default('draft');


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
