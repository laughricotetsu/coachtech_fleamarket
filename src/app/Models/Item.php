<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class Item extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'brand',
        'color',
        'description',
        'image_path',
        'condition',
        'is_sold'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
