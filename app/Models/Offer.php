<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable   = ['Title', 'Description', 'Image', 'Days','OfferType','discount','Level','GroupTag'];
    public $timestamps    = false;
    protected $primaryKey = 'OfferID';
    
}
