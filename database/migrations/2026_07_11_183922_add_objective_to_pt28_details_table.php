<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pt28_details', function (Blueprint $table) {
            $table->json('objective')->nullable();
        });
    }


    public function down()
    {
        Schema::table('pt28_details', function (Blueprint $table) {
            $table->dropColumn('objective');
        });
    }
};
