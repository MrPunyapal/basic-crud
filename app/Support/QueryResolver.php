<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

final readonly class QueryResolver
{
    /**
     * @var Collection<string, string>
     */
    private Collection $query;

    public function __construct()
    {

        /** @var array<string, string> */
        $query = request()->query();

        if (request()->routeIs('*.index')) {
            session()->put(Route::currentRouteName().'.previous.query', $query);
        }

        unset($query['page']);

        $this->query = collect($query);
    }

    /**
     * @return array<string, string>
     */
    public static function getPreviousQuery(string $routeName): array
    {
        /** @var array<string, string> */
        $query = session()->get($routeName.'.previous.query', []);

        return $query;
    }

    /**
     * @return array<string, string>
     */
    public function sortQuery(string $key): array
    {
        $query = $this->query->all();
        unset($query['sortBy'], $query['direction']);

        return $query +
            match ($this->query->get('sortBy')) {
                $key => $this->query->get('direction') === 'asc' ? ['sortBy' => $key, 'direction' => 'desc'] : [],
                default => ['sortBy' => $key, 'direction' => 'asc'],
            };
    }

    public function sortArrow(string $key): string
    {
        return $this->query->get('sortBy') === $key
        ? ($this->query->get('direction') === 'asc' ? '&uarr;' : '&darr;')
        : '&uarr;&darr;';
    }

    /**
     * @return array<string, string>
     */
    public function publishedQuery(): array
    {
        $query = $this->query->all();
        unset($query['published']);

        return $query + ($this->query->get('published') ? [] : ['published' => '1']);
    }

    public function publishedLabel(): string
    {
        return $this->query->get('published') ? __('posts.index.All Posts') : __('posts.index.Published Posts');
    }

    /**
     * @return array<string, string>
     */
    public function searchQuery(): array
    {
        $query = $this->query->all();
        unset($query['search']);

        return $query;
    }

    public function searchValue(): ?string
    {
        return $this->query->get('search');
    }
}
