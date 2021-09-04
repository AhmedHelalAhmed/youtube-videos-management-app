<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dates = [
        'favorite_at',
        'seen_at',
        'published_at'
    ];
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'channel_id',
        'published_at',
        'seen_at',
        'favorite_at',
        'remote_identifier',
    ];

    protected $appends=[
      'show_more',
      'link'
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function getShowMoreAttribute()
    {
        return false;
    }

    public function getLinkAttribute()
    {
        return config('youtube.urls.video_base_link').$this->remote_identifier;
    }

    public function getPublishedAtAttribute($val)
    {
        $dateTime=Carbon::parse($val);
        return $dateTime->diffForHumans().' | '.$dateTime->format('d-m-Y h:i:s a');
    }
}
