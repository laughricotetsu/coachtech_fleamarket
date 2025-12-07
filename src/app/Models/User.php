<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_text',
        'avatar_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** 出品商品 */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /** マイリスト（いいね） */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /** 購入履歴 */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /** 住所一覧 */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
