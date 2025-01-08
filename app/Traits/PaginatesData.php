<?php

namespace App\Traits;
use Illuminate\Pagination\LengthAwarePaginator;
trait PaginatesData
{
    private function getPaginationData($data)
    {
        return [
            'meta' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ],
            'links' => [
                'next' => $data->nextPageUrl(),
                'prev' => $data->previousPageUrl(),
            ]
        ];
    }
}
