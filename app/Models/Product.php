<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'foto',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relasi ke Kategori
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Relasi ke Merek
    |--------------------------------------------------------------------------
    */

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Relasi ke Order Items
    |--------------------------------------------------------------------------
    */

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}