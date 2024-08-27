<?php

namespace App\Repositories;

use App\Models\News;

class NewsRepository extends BaseRepository
{
    public const MODEL = News::class;

    public function search(array $params)
    {
        $query = $this->query();

        if (isset($params['keyword'])) {
            $query->where('title', 'like', '%'.$params['keyword'].'%')
                ->orWhere('content', 'like', '%'.$params['keyword'].'%');
        }

        return $query->paginate($params['per_page'] ?? 10);
    }
}
