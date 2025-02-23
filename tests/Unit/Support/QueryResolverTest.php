<?php

declare(strict_types=1);

use App\Models\Post;
use App\Support\QueryResolver;

beforeEach(function () {
    Post::factory(20)
        ->create();
});

it('can resolve sort query', function ($query, $expectedQuery) {

    $this->get(route('posts.index', $query));

    $resolver = new QueryResolver;

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

it('can resolve sort arrow', function ($query, $expectedArrow) {

    $this->get(route('posts.index', $query));

    $resolver = new QueryResolver;

    $sortArrow = $resolver->sortArrow('title');

    expect($sortArrow)->toEqual($expectedArrow);
})->with([
    [
        ['sortBy' => 'title', 'direction' => 'asc', 'page' => 1],
        '&uarr;',
    ],
    [
        ['sortBy' => 'title', 'direction' => 'desc'],
        '&darr;',
    ],
    [
        ['published' => true, 'search' => 'test', 'page' => 1],
        '&uarr;&darr;',
    ],
]);

it('can resolve published query', function ($query, $expectedQuery) {

    $this->get(route('posts.index', $query));

    $resolver = new QueryResolver;

    $publishedQuery = $resolver->publishedQuery();

    expect($publishedQuery)->toEqual($expectedQuery);
})->with([
    [
        ['published' => true, 'search' => 'test', 'page' => 1],
        ['search' => 'test'],
    ],
    [
        ['search' => 'test', 'page' => 1],
        ['published' => true, 'search' => 'test'],
    ],
]);

it('can resolve published label', function ($query, $expectedLabel) {

    $this->get(route('posts.index', $query));

    $resolver = new QueryResolver;

    $publishedLabel = $resolver->publishedLabel();

    expect($publishedLabel)->toEqual($expectedLabel);
})->with([
    [
        ['published' => true, 'search' => 'test', 'page' => 1],
        'All Posts',
    ],
    [
        ['search' => 'test', 'page' => 1],
        'Published Posts',
    ],
]);

it('can resolve search query', function ($query, $expectedQuery) {

    $this->get(route('posts.index', $query));

    $resolver = new QueryResolver;

    $searchQuery = $resolver->searchQuery();

    expect($searchQuery)->toEqual($expectedQuery);
})->with([
    [
        ['published' => true, 'search' => 'test', 'page' => 1],
        ['published' => true],
    ],
    [
        ['published' => true, 'page' => 1, 'sortBy' => 'title', 'direction' => 'asc'],
        ['published' => true, 'sortBy' => 'title', 'direction' => 'asc'],
    ],
]);

it('can resolve search value', function ($query, $expectedValue) {

    $this->get(route('posts.index', $query));

    $resolver = new QueryResolver;

    $searchValue = $resolver->searchValue();

    expect($searchValue)->toEqual($expectedValue);
})->with([
    [
        ['published' => true, 'search' => 'test', 'page' => 1],
        'test',
    ],
    [
        ['published' => true, 'page' => 1, 'sortBy' => 'title', 'direction' => 'asc'],
        null,
    ],
]);

it('can store previous query in session', function () {
    $routeName = 'posts.index';
    $query = ['sortBy' => 'title', 'direction' => 'asc', 'page' => 1];

    $this->get(route($routeName, $query));

    $storedQuery = session()->get($routeName.'.previous.query');

    expect($storedQuery)->toEqual($query);
});

it('can retrieve previous query from session', function () {
    $routeName = 'posts.index';
    $query = ['sortBy' => 'title', 'direction' => 'asc', 'page' => 1];

    session()->put($routeName.'.previous.query', $query);

    $previousQuery = QueryResolver::getPreviousQuery($routeName);

    expect($previousQuery)->toEqual($query);
});

it('returns empty array if previous query is not found in session', function () {
    $routeName = 'posts.index';

    $previousQuery = QueryResolver::getPreviousQuery($routeName);

    expect($previousQuery)->toEqual([]);
});
