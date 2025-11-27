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
        Schema::table('participant_receipts', function (Blueprint $table) {
            //
            Schema::table('participant_receipts', function (Blueprint $table) {
                $table->string('prefix')->nullable()->after('phone');

                $table->string('id_type')->nullable()->after('hbd');
                $table->string('citizen_id', 13)->nullable()->after('id_type');
                $table->string('passport_id')->nullable()->after('citizen_id');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participant_receipts', function (Blueprint $table) {
            //
            $table->dropColumn([
            'prefix','id_type','citizen_id','passport_id'
        ]);
        });
    }
};
