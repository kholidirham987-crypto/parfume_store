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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Percakapan tempat pesan berada
            $table->foreignId('conversation_id')
                ->constrained('conversations')
                ->onDelete('cascade');

            // User yang mengirim pesan
            // Bisa customer atau admin
            $table->foreignId('sender_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Isi pesan
            $table->text('message');

            // Apakah pesan sudah dibaca
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};