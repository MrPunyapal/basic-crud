<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\UploadedFile;

test('root redirects to posts', function () {
    $this->get('/')
        ->assertRedirect(route('posts.index'));
});

test('can see posts', function () {
    $this->get(route('posts.index'))
        ->assertOk()
        ->assertSessionHas('posts.index.previous.query', [])
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'posts',
        ]);
});

test('can only see published posts', function () {
    Post::factory(rand(1, 5))->create([
        'published_at' => now()->addDay(),
    ]);
    Post::factory(rand(1, 5))->create([
        'published_at' => now()->subDay(),
    ]);

    $this->get(route('posts.index', ['published' => true]))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertSessionHas('posts.index.previous.query', ['published' => true])
        ->assertViewHas('posts', fn ($posts) => $posts->where('published_at', '>=', now())->count() === 0);
});

test('can see posts sorted by title', function (string $direction) {
    $posts = Post::factory(3)
        ->sequence(
            ['title' => 'abc'],
            ['title' => 'bcd'],
            ['title' => 'cde'],
        )
        ->create();

    $expectedSortedPosts = ($direction === 'asc')
        ? $posts->pluck('title')->all()
        : $posts->pluck('title')->reverse()->all();

    $this->get(route('posts.index', [
        'sortBy' => 'title',
        'direction' => $direction,
    ]))
        ->assertOk()
        ->assertSessionHas('posts.index.previous.query', [
            'sortBy' => 'title',
            'direction' => $direction,
        ])
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'posts',
        ])
        ->assertSeeTextInOrder($expectedSortedPosts);
})->with(['asc', 'desc']);

test('can see posts sorted by invalid column', function () {
    Post::factory(10)->create();

    $this->get(route('posts.index', [
        'sortBy' => 'invalid-column',
    ]))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'posts',
        ]);
});

test('can search posts by title', function () {
    [$postToSearch, $missingPost] = Post::factory(2)->create();

    $searchTerm = $postToSearch->title;

    $this->get(route('posts.index', ['search' => $searchTerm]))
        ->assertOk()
        ->assertSessionHas('posts.index.previous.query', [
            'search' => $searchTerm,
        ])
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'posts',
        ])
        ->assertSeeText($searchTerm)
        ->assertDontSeeText($missingPost->title);
});

test('can see create post page', function () {
    $this->get(route('posts.create'))
        ->assertOk()
        ->assertViewIs('posts.create')
        ->assertViewHasAll([
            'categories',
            'tags',
        ]);
});

test('can create post', function () {
    $category = Category::factory()->create();
    $image = UploadedFile::fake()->image('some-image.png');
    $this->get(route('posts.index', ['published' => true]));
    $this->post(route('posts.store'), [
        'title' => 'Test Title',
        'slug' => 'test-title',
        'image' => $image,
        'category_id' => $category->id,
        'description' => 'this is the description',
        'content' => 'this is the content',
        'tags' => ['Eloquent'],
    ])
        ->assertRedirect(route('posts.index', ['published' => true]))
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Title',
    ]);
});

test('cannot create post with invalid data', function () {
    $this->post(route('posts.store'), [])
        ->assertRedirect()
        ->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'slug',
            'category_id',
            'description',
            'content',
        ]);
});

test('can see post page', function () {
    $post = Post::factory()->create();

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertViewHasAll([
            'post',
        ]);
});

test('can see edit post page', function () {
    $post = Post::factory()->create();

    $this->get(route('posts.edit', $post))
        ->assertOk()
        ->assertViewIs('posts.edit')
        ->assertViewHas([
            'post',
            'categories',
            'tags',
        ]);
});

test('can edit post', function () {
    $post = Post::factory()->create();

    $CategoryId = Category::factory()->create()->id;

    $image = UploadedFile::fake()->image('some-image.png');

    $this->get(route('posts.index', ['sortBy' => 'title', 'direction' => 'asc']));
    $this->patch(route('posts.update', $post), [
        'title' => 'updated Title',
        'slug' => 'test-title',
        'image' => $image,
        'category_id' => $CategoryId,
        'description' => 'this is the description',
        'content' => 'this is the content',
        'tags' => ['Eloquent'],
    ])
        ->assertRedirect(route('posts.index', ['sortBy' => 'title', 'direction' => 'asc']))
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('posts', [
        'title' => 'updated Title',
        'category_id' => $CategoryId,
    ]);
});

test('can delete post', function () {
    $post = Post::factory()->createOne();

    $this->get(route('posts.index', [
        'sortBy' => 'title',
        'direction' => 'asc',
        'page' => 2,
        'search' => 'test',
        'published' => true,
    ]));
    $this->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index', [
            'sortBy' => 'title',
            'direction' => 'asc',
            'page' => 2,
            'search' => 'test',
            'published' => true,
        ]));

    $this->assertSoftDeleted($post);
});
