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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            // Customer yang memiliki percakapan
            $table->foreignId('customer_id')
                ->constrained('users')
                ->onDelete('cascade');

            // open = aktif
            // closed = ditutup
            // archived = diarsipkan
            $table->string('status')->default('open');

            // Diisi ketika percakapan diarsipkan
            $table->timestamp('archived_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};