<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pt28', function (Blueprint $table) {
            $table->dropColumn('objective');
        });
    }

    public function down(): void
    {
        Schema::table('pt28', function (Blueprint $table) {
            $table->text('objective')->nullable();
        });
    }
};
