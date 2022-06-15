<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use HasFactory;


    protected $guarded = [];



    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class);
    }
}
