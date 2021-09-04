<?php


namespace App\Services;


use App\Models\Channel;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SyncVideosForGivenChannelService
{

    private $videosData = [];

    public function execute(Channel $channel)
    {
        $response = Http::get(config('youtube.urls.channel'), [
            'id' => $channel->remote_identifier,
            'part' => 'contentDetails',
            'key' => config('youtube.key')
        ])->json();
        $playlist = Arr::get($response, 'items.0.contentDetails.relatedPlaylists.uploads');
        $response = Http::get(config('youtube.urls.videos'), [
            'part' => 'snippet',
            'playlistId' => $playlist,
            'maxResults' => '50',
            'key' => config('youtube.key')
        ])->json();
        $this->AddMoreVideosData(Arr::get($response, 'items', []), $channel);
        while (isset($response['nextPageToken'])) {
            $response = Http::get(config('youtube.urls.videos'), [
                'part' => 'snippet',
                'playlistId' => $playlist,
                'maxResults' => '50',
                'key' => config('youtube.key'),
                'pageToken' => Arr::get($response, 'nextPageToken')
            ])->json();

            $this->AddMoreVideosData(Arr::get($response, 'items', []), $channel);
        }

        $videos = $this->filterVideosToNotExistsVideos($this->getExistsRemoteIds());

        if ($videos->isNotEmpty()) {
            return Video::insert($videos->toArray());
        }
        return true;
    }

    /**
     * @param array $videosData
     * @param $channel
     */
    private function AddMoreVideosData(array $videosData, $channel)
    {
        foreach ($videosData as $video) {
            $this->videosData[] = [
                'remote_identifier' => Arr::get($video, 'snippet.resourceId.videoId'),
                'title' => Arr::get($video, 'snippet.title'),
                'description' => Arr::get($video, 'snippet.description'),
                'thumbnail' => Arr::get($video, 'snippet.thumbnails.high.url'),
                'channel_id' => $channel->id,
                'published_at' => Carbon::parse(Arr::get($video, 'snippet.publishedAt')),
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }
    }

    /**
     * @param $existsRemoteIds
     * @return Collection
     */
    public function filterVideosToNotExistsVideos($existsRemoteIds): Collection
    {
        return collect($this->videosData)->filter(function ($video) use ($existsRemoteIds) {
            return !$existsRemoteIds->contains($video['remote_identifier']);
        });
    }

    /**
     * @return mixed
     */
    public function getExistsRemoteIds()
    {
        return Video::Select('remote_identifier')->pluck('remote_identifier');
    }

}
