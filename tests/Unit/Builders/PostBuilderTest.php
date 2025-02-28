<?php

declare(strict_types=1);

use App\Models\Post;
use Illuminate\Support\Fluent;

beforeEach(function () {
    $this->postA = Post::factory()->create([
        'title' => 'Test Post A',
        'published_at' => now()->subDay(),
        'created_at' => now()->subDays(2),
    ]);

    $this->postB = Post::factory()->create([
        'title' => 'Another Post B',
        'published_at' => now()->addDay(),
        'created_at' => now()->subDay(),
    ]);

    $this->postC = Post::factory()->create([
        'title' => 'Something Else C',
        'published_at' => now()->subDays(2),
        'created_at' => now()->subDays(3),
    ]);
});

test('filter builder can search posts by title', function () {
    $filters = new Fluent(['search' => 'Test']);

    $posts = Post::query()->filter($filters)->get();

    expect($posts)->toHaveCount(1)
        ->and($posts->first()->id)->toBe($this->postA->id);
});

test('filter builder can filter published posts', function () {
    $filters = new Fluent(['published' => true]);

    $posts = Post::query()->filter($filters)->get();

    expect($posts)->toHaveCount(2)
        ->and($posts->pluck('id')->toArray())->toContain($this->postA->id, $this->postC->id)
        ->and($posts->pluck('id')->toArray())->not->toContain($this->postB->id);
});

test('filter builder can sort posts by specified column and direction', function () {
    $filters = new Fluent([
        'sortBy' => 'created_at',
        'direction' => 'asc',
    ]);

    $posts = Post::query()->filter($filters)->get();

    expect($posts->pluck('id')->toArray())
        ->toBe([$this->postC->id, $this->postA->id, $this->postB->id]);
});

test('filter builder defaults to latest ordering when sort column is invalid', function () {
    $filters = new Fluent([
        'sortBy' => 'invalid_column',
    ]);

    $posts = Post::query()->filter($filters)->get();

    // Latest should sort by created_at desc
    expect($posts->pluck('id')->toArray())
        ->toBe([$this->postB->id, $this->postA->id, $this->postC->id]);
});

test('filter builder can combine multiple filters', function () {
    $filters = new Fluent([
        'search' => 'Post',
        'published' => true,
    ]);

    $posts = Post::query()->filter($filters)->get();

    expect($posts)->toHaveCount(1)
        ->and($posts->first()->id)->toBe($this->postA->id);
});
