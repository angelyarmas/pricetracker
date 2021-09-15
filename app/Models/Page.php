<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * Get the store for this page.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the currency for this page.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
