<?php

namespace App\Http\Controllers;

use App\Interfaces\VideoRepositoryInterface;
use App\Repositories\SearchTermRepository;
use App\Services\YoutubeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class VideoController extends BaseController
{
    private VideoRepositoryInterface $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function search(Request $request): JsonResponse
    {
        return response()->json([
            'application' => 'PSN API',
            'version' => App()->version(),
            'success' => true
        ]);
    }

    public function findById(Request $request, $id): JsonResponse
    {
        $video = $this->videoRepository->find($id);

        return response()->json([
            'application' => 'PSN API',
            'success' => true,
            'value' => $id,
        ]);
    }

    public function updateDatabase(SearchTermRepository $searchTermRepository, YoutubeService $youtubeService): JsonResponse
    {
        try {
            $searchTerms = $searchTermRepository->findAll();
        } catch (\InvalidArgumentException $exception) {
            Log::debug('Error loading search terms: ' . $exception->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Unable to load search terms',
            ]);
        }

        foreach ($searchTerms as $searchTerm) {
            error_log("Populating " . $searchTerm);
            $videos = $youtubeService->search($searchTerm);
            error_log(print_r($videos, true));
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
