<?php

use Illuminate\Support\Facades\File;

if(!function_exists('storeImage')){
    function storeImage($image, $path)
    {
        $imageName = time().'.'.$image->extension();
        $image->move(public_path($path), $imageName);

        return $imageName;
    }
}

if(!function_exists('deleteImage')){
    function deleteImage($image, $path)
    {
        if(File::exists(public_path($path.'/'.$image))){
            File::delete(public_path($path.'/'.$image));
        }
    }
}