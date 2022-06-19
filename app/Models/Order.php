<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;


    protected $guarded = [];



    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }


   
}
