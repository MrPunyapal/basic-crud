<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            ->assertOk();
    }
}
