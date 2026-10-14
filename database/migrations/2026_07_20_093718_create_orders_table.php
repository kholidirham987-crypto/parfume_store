<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
    Schema::create('orders', function (Blueprint $table) {

        $table->id();

        $table->foreignId('product_id')
              ->constrained()
              ->onDelete('cascade');

        $table->integer('jumlah');

        $table->integer('total_harga');

        $table->enum('status',[
            'Pending',
            'Lunas',
            'Batal'
        ])->default('Pending');

        $table->timestamps();

    });
    }


    public function down(): void
    {
        Schema::dropIfExists('orders');
    }

};