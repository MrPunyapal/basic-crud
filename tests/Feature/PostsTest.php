<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostsTest extends TestCase
{
    public function test_root_redirects_to_posts(): void
    {
        $this
            ->get('/')
            ->assertRedirect(route('posts.index'));
    }

    public function test_can_see_posts(): void
    {
        $this
            ->get(route('posts.index'))
            ->assertOk()
            ->assertViewIs('posts.index')
            ->assertViewHas('posts')
            ->assertViewHas('categories')
            ->assertViewHas('tags');
    }

    public function test_can_see_create_post_page(): void
    {
        $this
            ->get(route('posts.create'))
            ->assertOk()
            ->assertViewIs('posts.create')
            ->assertViewHas('categories')
            ->assertViewHas('tags');
    }

    public function test_can_create_post(): void
    {
        $image = UploadedFile::fake()->image('some-image.png');

        $this
            ->post(route('posts.store'), [
                'title' => 'Test Title',
                'slug' => 'test-title',
                'content' => 'Test Content',
                'image' => $image,
                'category' => ['Laravel'],
                'description' => 'this is the description',
                'body' => 'this is the body',
                'tags' => ['Eloquent'],
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Title'
        ]);
    }

    public function test_cannot_create_post_with_invalid_data(): void
    {
        $this
            ->post(route('posts.store'), [])
            ->assertSessionHasErrors([
                'title' => 'The title field is required.',
                'slug',
                'category',
                'description',
                'body'
            ])
            ->assertRedirect();
    }

    public function test_can_see_post_page(): void
    {
        $post = Post::factory()->create();

        $this
            ->get(route('posts.show', $post))
            ->assertOk()
            ->assertViewIs('posts.show')
            ->assertViewHas('post')
            ->assertViewHas('categories')
            ->assertViewHas('tags');
    }

    public function test_can_see_edit_post_page(): void
    {
        $post = Post::factory()->create();

        $this
            ->get(route('posts.edit', $post))
            ->assertOk()
            ->assertViewIs('posts.edit')
            ->assertViewHas('post')
            ->assertViewHas('categories')
            ->assertViewHas('tags');
    }

    public function test_can_edit_post(): void
    {
        $post = Post::factory()->create();

        $image = UploadedFile::fake()->image('some-image.png');

        $this
            ->patch(route('posts.update', $post), [
                'title' => 'updated Title',
                'slug' => 'test-title',
                'content' => 'Test Content',
                'image' => $image,
                'category' => ['Laravel'],
                'description' => 'this is the description',
                'body' => 'this is the body',
                'tags' => ['Eloquent'],
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'updated Title'
        ]);
    }

    public function test_can_delete_post(): void
    {
        $post = Post::factory()->create();

        $this
            ->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));
    }
}
