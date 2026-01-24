<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
    ];

    /** ユーザー */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** 商品 */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
