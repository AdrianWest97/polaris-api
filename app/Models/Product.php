<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;


class Product extends Model
{
    use HasFactory,CascadesDeletes;
    protected $cascadeDeletes = ['image'];

    protected $fillable = [
            'name',
            'description',
            'image_url',
            'stock',
            'price',
            'tags',
            'category_id',
            'caption',
            'is_featured',
            'visible',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function image(){
        return $this->hasOne(Image::class,'product_id');
    }
}