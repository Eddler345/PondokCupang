<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettaFish extends Model
{
    use HasFactory;

    protected $table = 'betta_fish';

    protected $fillable = [
        'name',
        'type',
        'price',
        'stock',
        'description',
        'image',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
