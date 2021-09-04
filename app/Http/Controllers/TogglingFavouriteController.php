<?php


namespace App\Http\Controllers;


use App\Models\Video;

class TogglingFavouriteController
{
    public function __invoke(Video $video)
    {
        $dateTime = null;
        if (is_null($video->favorite_at)) {
            $dateTime = now();
        }
        $video->update(['favorite_at' => $dateTime]);
        return back();
    }
}
