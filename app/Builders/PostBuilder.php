<?php

declare(strict_types=1);

namespace App\Builders;

use App\Enums\PostSortColumnsEnum;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Fluent;
use SortDirection;

/**
 * @template TModelClass of \App\Models\Post
 *
 * @extends Builder<Post>
 */
final class PostBuilder extends Builder
{
    public function search(string $search): static
    {
        $this->whereLike('title', '%'.$search.'%');

        return $this;
    }

    public function published(): static
    {
        $this->whereNowOrPast('published_at');

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
                $query->orderBy($filters->string('sortBy')->toString(), match ($filters->string('direction')->toString()) {
                    'asc' => SortDirection::Ascending,
                    'desc' => SortDirection::Descending,
                    default => SortDirection::Ascending,
                });
            },
            function (PostBuilder $query): void {
                $query->latest();
            },
        );

        return $this;
    }
}
