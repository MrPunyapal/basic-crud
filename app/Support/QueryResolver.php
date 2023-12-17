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

    public function publishedQuery(): array
    {
        return [
            ...request()
                ->collect()
                ->forget(['published'])
                ->toArray(),
            'published' => request('published') ? null : true,
        ];
    }

    public function publishedLabel(): string
    {
        return request('published') ? __('posts.index.All Posts') : __('posts.index.Published Posts');
    }

    public function searchQuery(): array
    {
        return request()
            ->collect()
            ->forget(['search'])
            ->toArray();
    }
}
