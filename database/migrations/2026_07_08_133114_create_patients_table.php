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
        Schema::create('patients', function (Blueprint $table) {

            $table->id();

            $table->string('hn')->unique();

            $table->string('cid')
                ->unique();

            $table->string('prefix')->nullable();

            $table->string('firstname');

            $table->string('lastname');


            $table->date('birthday')
                ->nullable();


            $table->integer('age')
                ->nullable();


            $table->string('gender')
                ->nullable();


            $table->string('nationality')
                ->nullable();


            $table->text('address')
                ->nullable();


            $table->string('province')
                ->nullable();


            $table->string('district')
                ->nullable();


            $table->string('subdistrict')
                ->nullable();


            $table->string('zipcode')
                ->nullable();


            $table->string('phone')
                ->nullable();


            $table->string('email')
                ->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
