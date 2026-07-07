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
     Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('entry_date');

            $table->string('reference_no')->unique();

            $table->text('description')->nullable();

            $table->enum('status', [
                'Draft',
                'Posted',
                'Voided'
            ])->default('Draft');

            // Posting
            $table->timestamp('posted_at')->nullable();

            // Void Information
            $table->timestamp('voided_at')->nullable();

            $table->text('void_reason')->nullable();

            // Links to the reversing entry
            $table->foreignId('reversal_entry_id')
                ->nullable()
                ->constrained('journal_entries')
                ->nullOnDelete();

            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_journal_entry');
    }
};
