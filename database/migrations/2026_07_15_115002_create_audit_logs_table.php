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
        Schema::create('audit_logs', function (Blueprint $table) {

            $table->id();

            // คนทำรายการ
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('user')
                ->nullOnDelete();


            // สาขา
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();


            // Action เช่น CREATE UPDATE DELETE LOGIN
            $table->string('action');


            // Model ที่ถูกกระทำ
            $table->string('auditable_type');

            $table->unsignedBigInteger('auditable_id');


            $table->text('description')
                ->nullable();


            $table->ipAddress('ip_address')
                ->nullable();


            // ข้อมูลก่อนแก้
            $table->json('old_values')
                ->nullable();


            // ข้อมูลหลังแก้
            $table->json('new_values')
                ->nullable();


            $table->timestamps();


            $table->index([
                'auditable_type',
                'auditable_id'
            ]);


            $table->index('user_id');

            $table->index('branch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
