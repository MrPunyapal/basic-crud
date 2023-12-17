<?php

use App\Models\Post;
use App\Support\QueryResolver;

use function Pest\Laravel\get;

uses(Tests\TestCase::class);

beforeEach(function () {
    Post::factory(20)
        ->create();
});

it('can resolve sort query', function ($query, $expectedQuery) {

    get(route('posts.index', $query));

    $resolver = new QueryResolver();

    $sortQuery = $resolver->sortQuery('title');

    expect($sortQuery)->toEqual($expectedQuery);
})->with([
    [
        ['sortBy' => 'title', 'direction' => 'asc', 'page' => 1],
        ['sortBy' => 'title', 'direction' => 'desc'],
    ],
    [
        ['sortBy' => 'title', 'direction' => 'desc'],
        [],
    ],
    [
        ['published' => true, 'search' => 'test', 'page' => 1],
        ['published' => true, 'search' => 'test', 'sortBy' => 'title', 'direction' => 'asc'],
    ],
]);
