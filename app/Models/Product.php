<?php

namespace App\Models;

// app/Models/Product.php

class Product extends Model
{
    protected $fillable = [
        'name_product',
        'price_product',
        'brand_product',
        'count_product',
        'path_product',
        'mechanism_product',
        'weight',
        'size',
        'color',
        'info',
        // другие существующие поля
    ];

    // ваши отношения и другие методы модели
}

