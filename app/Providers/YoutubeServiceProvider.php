<?php


namespace App\Providers;


use App\Repositories\ChannelRepository;
use App\Services\YoutubeService;
use Illuminate\Support\ServiceProvider;

class YoutubeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(YoutubeService::class, function () {
            return new YoutubeService(new ChannelRepository());
        });
    }
}
