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

            $table->foreignId('branch_id')
                ->constrained('branches')
                ->cascadeOnDelete();

            $table->foreignId('patient_id')
                ->constrained('patient')
                ->cascadeOnDelete();


            $table->foreignId('visit_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();


            $table->foreignId('medic_id')
                ->nullable()
                ->constrained('medics')
                ->nullOnDelete();


            $table->string('document_no')
                ->unique();


            $table->date('issue_date');


            // การวินิจฉัย
            $table->string('diagnosis')
                ->nullable();


            // วิชาชีพ
            $table->string('profession')
                ->nullable();


            // รายละเอียดใบรับรอง
            $table->text('certificate')
                ->nullable();


            // กัญชา
            $table->decimal('cannabis_dosage', 10, 2)
                ->nullable();


            $table->integer('cannabis_use_days')
                ->nullable();


            $table->string('cannabis_dosage_unit')
                ->nullable();


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
        Schema::dropIfExists('pt33');
    }
};
