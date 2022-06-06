<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
