<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
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
        $video = VideoRepository::find($id);

        return response()->json([
            'application' => 'PSN API',
            'success' => true,
            'value' => $id,
        ]);
    }

    public function updateDatabases(): JsonResponse
    {
        $searchTerms = TermRepository::loadTerms();

    }
}
