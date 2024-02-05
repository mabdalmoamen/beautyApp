<?php

namespace  App\Traits;

use Image;

trait ImagesTrait
{
    public function UploadImage($img, $path)
    {
        $position = strpos($img, ';');
        $sub = substr($img, 0, $position);
        $ext = explode('/', $sub)[1];
        $name = time() . "." . $ext;
        $img = Image::make($img)->resize(240, 200);
        $image_url = $path . $name;
        $img->save($image_url);
        return $image_url;
    }
}
