<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Transaction extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['payment_method', 'payment_status', 'payment_currency'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
