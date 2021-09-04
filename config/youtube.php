<?php

return [

    'urls' => [
        'base'=> env('YOUTUBE_BASE_URL_API'),
        'channel' => env('YOUTUBE_CHANNEL_URL_API'),
        'videos' => env('YOUTUBE_CHANNEL_videos_URL_API'),
        'video_base_link' => env('YOUTUBE_VIDEO_BASE_LINK'),
        'search' => env('YOUTUBE_CHANNEL_SEARCH_API'),
    ],


    'key' => env('YOUTUBE_API_KEY'),
];
