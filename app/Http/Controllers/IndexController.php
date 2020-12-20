<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'application' => 'PSN API',
            'version' => App()->version(),
            'success' => true
        ]);
    }
}
