<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participant_receipt_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('participant_receipt_id')
                ->constrained('participant_receipts')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('action');      // approved / rejected
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participant_receipt_logs');
    }
};
