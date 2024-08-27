<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\IndexRequest;
use App\Http\Resources\NewsCollection;
use App\Services\NewsService;

class NewsController extends Controller
{
    protected NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(IndexRequest $request)
    {
        try {
            $params = $request->validated();
            $search_data = $this->newsService->search($params);
            $result = new NewsCollection($search_data);

            return $this->responseSuccess('Get news successfully', $result);
        } catch (\Throwable $th) {
            return $this->responseUnAuthenticated($th->getMessage());
        }
    }
}
