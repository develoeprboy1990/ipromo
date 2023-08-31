<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'OfferID', 'CustomerID', 'product_id', 'description', 'payment_status', 'payment_description',
        'payment_message', 'log_record', 'subtotalprice', 'totalprice'
    ];
    /*  public $timestamps = false;
    protected $primaryKey = 'OfferID'; */
}
