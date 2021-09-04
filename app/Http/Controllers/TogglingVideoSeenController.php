<?php


namespace App\Http\Controllers;


use App\Models\Video;

class TogglingVideoSeenController
{
    public function __invoke(Video $video)
    {
        $dateTime = null;
        if (is_null($video->seen_at)) {
            $dateTime = now();
        }
        $video->update(['seen_at' => $dateTime]);

        return back();
    }
}
