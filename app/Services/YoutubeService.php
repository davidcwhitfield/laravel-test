<?php

namespace App\Services;

use App\Repositories\ChannelRepository;
use Illuminate\Support\Facades\Http;

class YoutubeService
{
    private const YOUTUBE_API_ENDPOINT = 'https://youtube.googleapis.com/youtube/v3';

    private ChannelRepository $channelRepository;

    private string $apiKey;

    public function __construct(ChannelRepository $channelRepository)
    {
        $this->channelRepository = $channelRepository;

        $this->apiKey = config('api.youtube.api_key');

        if (empty($this->apiKey)) {
            throw new \Exception("No YouTube API key provided");
        }
    }

    public function search($query)
    {
        $data = [];

        $channelIds = $this->loadChannelIds();

        $page = 1;
        foreach ($channelIds as $channelId) {
            error_log("Page: " . $page);
            $pageToken = null;
            do {
                $responseData = $this->loadData($query, $channelId, $pageToken);
                error_log(print_r($responseData, true));
                array_merge($data, $responseData['items']);
                $pageToken = $responseData['nextPageToken'];
                $page++;
            } while (!empty($responseData['nextPageToken']));
        }

        return $data;
    }

    private function loadData(string $query, ?string $channelId = null, ?string $pageToken = null) {
        $queryData = [
            'q' => $query,
            'key' => $this->apiKey,
            'maxResults' => 50,
        ];

        if ($channelId !== null) {
            $queryData['channel'] = $channelId;
        }

        if ($pageToken !== null) {
            $queryData['pageToken'] = $pageToken;
        }

        return Http::get('https://youtube.googleapis.com/youtube/v3/search', $queryData)->json();
    }

    /**
     * @param array $channels
     * @throws \Exception
     */
    private function loadChannelIds(): array
    {
        $channelIds = [];

        foreach ($this->channelRepository->findAll() as $channel) {
            $channelName = $channel->channel_name;

            $response = Http::get('https://youtube.googleapis.com/youtube/v3/channels', [
                'forUsername' => $channelName,
                'key' => $this->apiKey,
            ]);

            if (!$response->ok()) {
                $body = $response->json();
                throw new \RuntimeException('Invalid response from Youtube API: ' . $body['error']['message']);
            }

            if ($response['pageInfo']['totalResults'] === 0) {
                throw new \Exception("Unable to find channel '$channelName'");
            }

            $channelIds[] = $response['items'][0]['id'];
        }

        return $channelIds;
    }
}
