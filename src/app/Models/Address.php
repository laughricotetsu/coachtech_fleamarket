<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'postal_code',
        'prefecture',
        'city',
        'street',
        'building',
    ];

    /** 所有者 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** 購入履歴（配送先として使われた履歴） */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
