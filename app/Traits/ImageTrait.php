<?php

namespace App\Traits;



use Illuminate\Http\Request;


trait ImageTrait
{
    public function saveImage($image, $path = null)
    {
        // $image = ;
        // $image = $image->file('image');
        // dd($image);
        // die;
        $name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path() . '/images/', $name);
        return $name;
    }

    public function saveImages($image, $path = null)
    {


        // $name = $image->getClientOriginalName();
        $name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path() . '/images/', $name);
        $images[] = $name;

        return $images;
    }
}
