<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Get the historical_lowest_price for this product.
     */
    public function historical_lowest_price()
    {
        return $this->hasOne(Price::class, null, 'historical_lowest_id');
    }

    /**
     * Get the current_lowest_price for this product.
     */
    public function current_lowest_price()
    {
        return $this->hasOne(Price::class, null, 'current_lowest_id');
    }
}
