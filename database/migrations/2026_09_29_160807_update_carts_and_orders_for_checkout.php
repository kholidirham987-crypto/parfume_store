<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CARTS
        |--------------------------------------------------------------------------
        */

        // user_id sudah ada, jadi tidak dibuat lagi.


        /*
        |--------------------------------------------------------------------------
        | ORDERS
        |--------------------------------------------------------------------------
        */

        Schema::table('orders', function (Blueprint $table) {

            if (!Schema::hasColumn('orders', 'kecamatan')) {
                $table->string('kecamatan')
                    ->nullable()
                    ->after('kota');
            }

            if (!Schema::hasColumn('orders', 'layanan_kurir')) {
                $table->string('layanan_kurir')
                    ->nullable()
                    ->after('kurir');
            }

            if (!Schema::hasColumn('orders', 'status_pembayaran')) {
                $table->enum('status_pembayaran', [
                    'menunggu_verifikasi',
                    'terverifikasi',
                    'ditolak',
                    'belum_dibayar',
                    'dibayar',
                ])
                ->default('belum_dibayar')
                ->after('metode_pembayaran');
            }

            if (!Schema::hasColumn('orders', 'status_pesanan')) {
                $table->enum('status_pesanan', [
                    'menunggu_verifikasi',
                    'diproses',
                    'dikirim',
                    'selesai',
                    'dibatalkan',
                ])
                ->default('diproses')
                ->after('status_pembayaran');
            }

            if (!Schema::hasColumn('orders', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')
                    ->nullable()
                    ->after('status_pesanan');
            }

            if (!Schema::hasColumn('orders', 'catatan_customer')) {
                $table->text('catatan_customer')
                    ->nullable()
                    ->after('bukti_pembayaran');
            }

            if (!Schema::hasColumn('orders', 'catatan_admin')) {
                $table->text('catatan_admin')
                    ->nullable()
                    ->after('catatan_customer');
            }

        });
    }


    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $columns = [
                'kecamatan',
                'layanan_kurir',
                'status_pembayaran',
                'status_pesanan',
                'bukti_pembayaran',
                'catatan_customer',
                'catatan_admin',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }

        });
    }
};