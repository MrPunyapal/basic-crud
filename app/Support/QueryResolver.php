<?php

namespace App\Support;

class QueryResolver
{
    public function sortQuery(string $key): array
    {
        return [
            ...request()
                ->collect()
                ->forget(['sort', 'direction'])
                ->toArray(),
            ...request('sort') === $key ? (request('direction') === 'asc' ? ['sort' => $key, 'direction' => 'desc'] : []) : ['sort' => $key, 'direction' => 'asc'],
        ];
    }

    public function sortArrow(string $key): string
    {
        return request('sort') === $key ? (request('direction') === 'asc' ? '&darr;' : '&uarr;') : '&darr;&uarr;';
    }
}
