<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'stock',
        'weight',
        'price',
        'thumbnail',
        'image',
        'description',
        'category_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function likes(){
        return $this->belongsTo(Likes::class);
    }

    public function order_details(){
        return $this->hasMany(OrderDetails::class);
    }
}
