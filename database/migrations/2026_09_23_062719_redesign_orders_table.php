<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nama_penerima')
                ->nullable()
                ->after('kode_pesanan');

            $table->string('no_hp')
                ->nullable()
                ->after('nama_penerima');

            $table->text('alamat')
                ->nullable()
                ->after('no_hp');

            $table->string('kota')
                ->nullable()
                ->after('alamat');

            $table->string('kurir')
                ->nullable()
                ->after('kota');

            $table->integer('ongkir')
                ->default(0)
                ->after('kurir');

            $table->integer('subtotal')
                ->default(0)
                ->after('ongkir');

            $table->string('metode_pembayaran')
                ->nullable()
                ->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penerima',
                'no_hp',
                'alamat',
                'kota',
                'kurir',
                'ongkir',
                'subtotal',
                'metode_pembayaran',
            ]);
        });
    }
};