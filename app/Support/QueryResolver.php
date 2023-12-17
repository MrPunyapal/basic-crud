<?php

namespace App\Support;

use Illuminate\Support\Collection;

class QueryResolver
{
    private Collection $query;

    public function __construct()
    {
        $this->query = request()->collect()->forget(['page']);
    }

    public function sortQuery(string $key): array
    {
        $query = $this->query->toArray();
        unset($query['sortBy'], $query['direction']);

        return [
            ...$query,
            ...match ($this->query->get('sortBy')) {
                $key => $this->query->get('direction') === 'asc' ? ['sortBy' => $key, 'direction' => 'desc'] : [],
                default => ['sortBy' => $key, 'direction' => 'asc'],
            },
        ];
    }

    public function sortArrow(string $key): string
    {
        return $this->query->get('sortBy') === $key
        ? ($this->query->get('direction') === 'asc' ? '&darr;' : '&uarr;')
        : '&darr;&uarr;';
    }

    public function publishedQuery(): array
    {
        $query = $this->query->toArray();
        unset($query['published']);

        return [
            ...$query,
            'published' => $this->query->get('published') ? null : true,
        ];
    }

    public function publishedLabel(): string
    {
        return $this->query->get('published') ? __('posts.index.All Posts') : __('posts.index.Published Posts');
    }

    public function searchQuery(): array
    {
        $query = $this->query->toArray();
        unset($query['search']);

        return $query;
    }

    public function searchValue(): ?string
    {
        return $this->query->get('search');
    }
}
