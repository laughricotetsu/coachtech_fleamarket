<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'status',
    ];

    /** 出品者 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** 商品画像（複数） */
    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }

    /** マイリスト（いいね） */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /** 購入情報（1商品1回の購入） */
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    /** 多対多：カテゴリ */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_categories');
    }

    /** 便利メソッド：この商品をユーザーがいいねしてる？ */
    public function isLikedBy($user)
    {
        if (!$user) return false;

        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
