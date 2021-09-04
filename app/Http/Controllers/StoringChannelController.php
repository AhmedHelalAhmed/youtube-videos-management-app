<?php


namespace App\Http\Controllers;


use App\Models\Channel;
use Illuminate\Support\Arr;

class StoringChannelController
{
    public function __invoke()
    {
        Channel::create(array_merge(request()->only(['name', 'remote_identifier']),['user_id'=>auth()->id()]));

        return back();
    }
}
