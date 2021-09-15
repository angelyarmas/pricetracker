<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    /**
     * Get the product for this price.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
