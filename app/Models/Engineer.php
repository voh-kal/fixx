<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    protected $fillable = [
        'user_id',
        'shop_id',
    ];

    public function Engineer(){
        $this->belongsTo(Shop::class);
    }
    use HasFactory;
}
