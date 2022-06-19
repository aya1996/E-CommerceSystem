<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'latitude',
        'longitude',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function scopeDistance($query, $latitude, $longitude)
    {
        // "6371 * acos(cos(radians(" . $lat . ")) 
        //         * cos(radians(users.lat)) 
        //         * cos(radians(users.lon) - radians(" . $lon . ")) 
        //         + sin(radians(" .$lat. ")) 
        //         * sin(radians(users.lat))) 
        //         AS distance";

        // return $query->where('latitude', $latitude)->where('longitude', $longitude);
        return $query->selectRaw("*, (6371 * acos(cos(radians($latitude)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) - radians($longitude)) 
                + sin(radians($latitude)) 
                * sin(radians(latitude)))) AS distance")
          
            ->groupBy('id')
            ->orderBy('distance');
    }
}
// $data = DB::table("users")
//     ->select(
//         "users.id",
//         DB::raw("6371 * acos(cos(radians(" . $latitude . ")) 
//     * cos(radians(users.lat)) 
//     * cos(radians(users.lon) - radians(" . $longitude . ")) 
//     + sin(radians(" . $latitude . ")) 
//     * sin(radians(users.lat))) AS distance")
//     )
//     ->groupBy("users.id")
//     ->get();
// dd($data);
