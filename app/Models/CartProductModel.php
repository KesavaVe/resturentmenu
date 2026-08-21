<?php

namespace App\Models;

use CodeIgniter\Model;

class CartProductModel extends Model
{
    protected $table = 'cart_products';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'name',
        'price',
        'status',
        'created_at',
        'updated_at',
    ];
}