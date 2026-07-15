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
        Schema::create('medics', function (Blueprint $table) {

            $table->id();

            $table->string('prefix')->nullable();


            $table->string('firstname');

            $table->string('lastname');

            $table->string('phone', 20)
                ->nullable();


            // เลขใบอนุญาต
            $table->string('license');


            // path รูปลายเซ็น
            $table->string('signature')
                ->nullable();


            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medics_tabel');
    }
};
