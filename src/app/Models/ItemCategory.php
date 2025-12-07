<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'category_id',
    ];

    /** 商品 */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /** カテゴリ */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
