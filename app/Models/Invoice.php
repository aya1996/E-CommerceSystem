<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Invoice extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['status'];

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
        return $this->hasMany(InvoiceProduct::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }
}
