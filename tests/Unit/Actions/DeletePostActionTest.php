<?php

declare(strict_types=1);

use App\Actions\Posts\DeletePostAction;
use App\Models\Post;

it('deletes a post', function () {
    $post = Post::factory()->create();

    $action = new DeletePostAction;
    $action->execute($post);

    $this->assertSoftDeleted('posts', ['id' => $post->id]);
});
