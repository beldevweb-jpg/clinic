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
        Schema::table('patient', function (Blueprint $table) {

            // ชื่อภาษาอังกฤษ
            $table->string('firstname_en')->nullable()->after('firstname');
            $table->string('lastname_en')->nullable()->after('lastname');

            // ข้อมูลบัตรประชาชน
            $table->date('card_issue_date')->nullable()->after('birthday');
            $table->date('card_expire_date')->nullable()->after('card_issue_date');

            // รูปจากชิปบนบัตร
            $table->string('card_photo')->nullable()->after('card_expire_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient', function (Blueprint $table) {

            $table->dropColumn([
                'firstname_en',
                'lastname_en',
                'card_issue_date',
                'card_expire_date',
                'card_photo',
            ]);
        });
    }
};
