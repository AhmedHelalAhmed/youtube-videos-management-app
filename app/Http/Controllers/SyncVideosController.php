<?php

namespace App\Http\Controllers;

use App\Jobs\SyncVideosForGivenChannelJob;
use App\Models\Channel;

class SyncVideosController
{
    public function __invoke(Channel $channel)
    {
        dispatch(new SyncVideosForGivenChannelJob($channel));
        return back()->with('message', 'Sync under processing please wait some minutes and try to refresh the page again. . .');
    }
}
