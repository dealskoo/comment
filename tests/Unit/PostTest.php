<?php

namespace Dealskoo\Comment\Tests\Unit;

use Dealskoo\Comment\Models\Comment;
use Dealskoo\Comment\Tests\Post;
use Dealskoo\Comment\Tests\TestCase;
use Dealskoo\Comment\Tests\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_comments()
    {
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $this->assertCount(1, $post->comments()->get());
    }

    public function test_approved_comments()
    {
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $this->assertCount(1, $post->approvedComments()->get());
    }

    public function test_comment()
    {
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $post->comment($user, $comment->comment, $comment->score);
        $this->assertCount(1, $post->comments()->get());
    }
}
