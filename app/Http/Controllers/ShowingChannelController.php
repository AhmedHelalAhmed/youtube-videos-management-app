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
                ->when(request('title'), function ($q,$title) {
                    $q->where('title','like','%'.$title.'%');
                })
                ->when(request('is_favorite') === 'no', function ($q) {
                    $q->whereNull('favorite_at');
                })
                ->when(request('is_favorite') === 'yes', function ($q) {
                    $q->whereNotNull('favorite_at');
                })
                ->when(request('is_seen') === 'no', function ($q) {
                    $q->whereNull('seen_at');
                })
                ->when(request('is_seen',) === 'yes', function ($q) {
                    $q->whereNotNull('seen_at');
                })
                ->paginate()
                ->appends(request()->all())
        ]);
    }
}
