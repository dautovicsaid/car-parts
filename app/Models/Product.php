<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'min_applicable_year',
        'max_applicable_year',
        'model_id',
        'category_id',
    ];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
