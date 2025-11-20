<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'betta_fish_id',
        'quantity',
        'total_price',
        'status',
    ];

    // Relasi ke pengguna
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke ikan cupang
    public function bettaFish()
    {
        return $this->belongsTo(BettaFish::class, 'betta_fish_id');
    }
}
