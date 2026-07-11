<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pt28_details', function (Blueprint $table) {
            $table->dropColumn('flower_unit');
        });
    }

    public function down(): void
    {
        Schema::table('pt28_details', function (Blueprint $table) {
            $table->string('flower_unit')->nullable();
        });
    }
};
