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
        Schema::create('medic_professions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('medic_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->string('profession');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medic_professions');
    }
};
