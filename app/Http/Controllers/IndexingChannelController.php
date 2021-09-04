<?php

namespace App\Http\Controllers;

use App\Models\Channel;

class IndexingChannelController
{
    public function __invoke()
    {
        return inertia()->render(
            'Channels/index',
            [
                'channels' => Channel::where('user_id', auth()->id())
                    ->withCount('videos')
                    ->paginate()
            ]
        );
    }
}
