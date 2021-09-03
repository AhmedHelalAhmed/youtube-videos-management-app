<?php


namespace App\Http\Controllers;


use App\Models\Channel;

class ShowingChannelController
{
    public function __invoke(Channel $channel)
    {
        return inertia()->render('Channels/Videos/index', ['channel' => $channel]);
    }
}
