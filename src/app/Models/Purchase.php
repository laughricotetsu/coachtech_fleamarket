<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'address_id',
        'total_price',
    ];

    /** 購入者 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** 購入商品 */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /** 配送先住所 */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
