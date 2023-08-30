<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['Title', 'Description', 'Image', 'Days','discount'];
    public $timestamps = false;
    protected $primaryKey = 'OfferID';
}
