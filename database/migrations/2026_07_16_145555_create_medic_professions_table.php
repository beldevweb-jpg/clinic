<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medic_professions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('medic_id')
                ->constrained('medics')
                ->cascadeOnDelete();

            $table->foreignId('profession_id')
                ->constrained('professions')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'medic_id',
                'profession_id'
            ]);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('medic_professions');
    }
};