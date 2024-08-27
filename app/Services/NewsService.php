<?php

namespace App\Services;

use App\Repositories\NewsRepository;

class NewsService
{
    protected NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function search(array $params): mixed
    {
        return $this->newsRepository->search($params);
    }
}
