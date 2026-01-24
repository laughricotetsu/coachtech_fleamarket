<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Item;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /** 商品との多対多 */
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
