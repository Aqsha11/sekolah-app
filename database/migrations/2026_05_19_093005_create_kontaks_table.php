<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel kontak
     */
    public function up(): void
    {
        Schema::create('kontak', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->longText('message');
            $table->enum('status', ['unread', 'read', 'replied'])->default('unread');
            $table->longText('reply_message')->nullable();
            $table->foreignId('replied_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('email');
        });
    }

    /**
     * Hapus tabel kontak
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak');
    }
};