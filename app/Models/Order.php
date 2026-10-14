<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'kode_pesanan',

        // Data penerima
        'nama_penerima',
        'no_hp',
        'alamat',
        'kota',
        'kecamatan',

        // Pengiriman
        'kurir',
        'layanan_kurir',
        'ongkir',

        // Harga
        'subtotal',
        'total_harga',

        // Pembayaran
        'metode_pembayaran',
        'status_pembayaran',

        // Status pesanan
        'status_pesanan',

        // Bukti pembayaran
        'bukti_pembayaran',

        // Catatan
        'catatan_customer',
        'catatan_admin',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relasi ke User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Relasi ke Order Items
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}