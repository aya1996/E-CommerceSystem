<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTax extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
