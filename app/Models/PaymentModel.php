<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'payment_id',
        'order_id',
        'payment_date',
        'amount_due',
        'tips',
        'discount',
        'total_paid',
        'payment_type',
        'payment_status',
    ];
}