<?php

namespace App\Traits;

trait UseCollection
{
    public function paginateWrapper($data, $resource)
    {
        $paginator = $resource->resource;

        return [
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
            ],
        ];
    }
}
