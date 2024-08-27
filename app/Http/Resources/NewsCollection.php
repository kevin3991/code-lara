<?php

namespace App\Http\Resources;

use App\Traits\UseCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsCollection extends ResourceCollection
{
    use UseCollection;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        $data = collect($this->collection)->map(function ($item) {
            $result = new NewsResource($item);

            return $result->resolve();
        });

        return $this->paginateWrapper($data, $this);
    }
}
