<?php


namespace App\Http\Controllers;


use App\Models\Channel;
use App\Models\Video;

class ShowingChannelController
{
    public function __invoke(Channel $channel)
    {
        return inertia()->render('Channels/Videos/index', [
            'channel' => $channel,
            'videos' => Video::where('channel_id', $channel->id)
                ->orderByDesc('published_at')
                ->paginate()
        ]);
    }
}
