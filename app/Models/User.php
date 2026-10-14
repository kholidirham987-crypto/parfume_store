<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Conversation;
use App\Models\Message;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Percakapan yang dimiliki customer
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'customer_id');
    }

    /**
     * Semua pesan yang dikirim user
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}