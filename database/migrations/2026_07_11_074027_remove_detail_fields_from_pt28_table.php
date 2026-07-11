<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pt28', function (Blueprint $table) {
            $table->dropForeign(['medic_id']);

            $table->dropColumn([
                'license_no',
                'medic_id',
                'dosage',
                'flower_unit',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('pt28', function (Blueprint $table) {
            $table->string('license_no')->nullable();
            $table->unsignedBigInteger('medic_id')->nullable();
            $table->string('dosage')->nullable();
            $table->decimal('flower_unit', 10, 2)->nullable();
        });
    }
};
