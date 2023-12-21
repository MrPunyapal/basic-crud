<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \App\Models\Post
 *
 * @extends \Illuminate\Database\Eloquent\Builder<\App\Models\Post>
 */
class PostBuilder extends Builder
{
    public function search(string $search): static
    {
        $this->where('title', 'like', '%'.$search.'%');

        return $this;
    }

    public function sortBy(string $column, string $direction = 'asc'): static
    {
        $this->orderBy($column, $direction);

        return $this;
    }

    public function published(): static
    {
        $this->where('published_at', '<=', now());

        return $this;
    }
}
