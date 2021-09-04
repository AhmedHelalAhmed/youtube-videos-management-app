<?php


namespace App\Services;


use ArrayAccess;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GettingChannelIdByLinkService
{
    /**
     * @param string $link
     * @return array|ArrayAccess|mixed
     */
    public function execute(string $link)
    {
        $response = Http::get(config('youtube.urls.search'), [
            'part' => 'snippet',
            'q' => $link,
            'type' => 'channel',
            'key' => config('youtube.key')
        ])->json();


        if (!Arr::get($response, 'items')) {
            $linkParts = collect(explode('/', $link));
            $response = Http::get(config('youtube.urls.search'), [
                'part' => 'snippet',
                'q' => $linkParts->last(),
                'type' => 'channel',
                'key' => config('youtube.key')
            ])->json();
        }

        return Arr::get($response, 'items.0.snippet.channelId');
    }
}
