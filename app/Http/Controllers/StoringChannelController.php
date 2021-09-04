<?php


namespace App\Http\Controllers;


use App\Http\Requests\StoreChannelRequest;
use App\Models\Channel;

class StoringChannelController
{
    public function __invoke(StoreChannelRequest $request)
    {
        Channel::create($request->validated());

        return back();
    }
}
