<?php

declare(strict_types=1);

namespace App\Builders;

use App\Enums\PostSortColumnsEnum;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Fluent;

/**
 * @template TModelClass of \App\Models\Post
 *
 * @extends Builder<Post>
 */
final class PostBuilder extends Builder
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

    /**
     * @param  Fluent<string, mixed>  $filters
     */
    public function filter(Fluent $filters): static
    {
        $this->when($filters->string('search')->toString(), function (PostBuilder $query, string $search): void {
            $query->search($search);
        })->when($filters->get('published'), function (PostBuilder $query): void {
            $query->published();
        })->when(
            in_array($filters->get('sortBy'), PostSortColumnsEnum::columns(), true),
            function (PostBuilder $query) use ($filters): void {
                $query->sortBy($filters->string('sortBy')->toString(), $filters->string('direction')->toString());
            },
            function (PostBuilder $query): void {
                $query->latest();
            },
        );

        return $this;
    }
}
