<?php

use App\Models\Post;
use App\Support\QueryResolver;

use function Pest\Laravel\get;

uses(Tests\TestCase::class);

it('can resolve sort query', function () {
    Post::factory(20)
        ->create();

    get(route('posts.index', [
        'sortBy' => 'title',
        'direction' => 'asc',
        'page' => 1,
    ]));

    $resolver = new QueryResolver();

    $sortQuery = $resolver->sortQuery('title');

    expect($sortQuery)->toEqual([
        'sortBy' => 'title',
        'direction' => 'desc',
    ]);
});
