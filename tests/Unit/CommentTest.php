<?php

namespace Dealskoo\Comment\Tests\Unit;

use Dealskoo\Comment\Models\Comment;
use Dealskoo\Comment\Tests\Post;
use Dealskoo\Comment\Tests\TestCase;
use Dealskoo\Comment\Tests\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_commenter()
    {
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $comment = $user->comments()->first();
        $this->assertEquals($user->name, $comment->commenter()->first()->name);
    }

    public function test_commentable()
    {
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $comment = $user->comments()->first();
        $this->assertEquals($post->title, $comment->commentable()->first()->title);
    }

    public function test_children()
    {
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $user1 = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $comment1 = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $comment = $user->comments()->first();
        $user1->comment($post, $comment1->comment, $comment1->score, $comment->id);
        $user1->comment($post, $comment1->comment, $comment1->score, $comment->id);
        $this->assertCount(2, $comment->children()->get());
    }

    public function test_parent()
    {
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $user1 = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $comment1 = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $comment = $user->comments()->first();
        $user1->comment($post, $comment1->comment, $comment1->score, $comment->id);
        $comment1 = $user1->comments()->first();
        $this->assertEquals($comment->id, $comment1->parent->id);
    }

    public function test_scope_approved()
    {
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $comment1 = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $user->comment($post, $comment1->comment, $comment1->score);
        $this->assertCount(2, $user->comments()->get());
        $comment = Comment::query()->first();
        $comment->approved = false;
        $comment->save();
        $this->assertCount(1, $user->comments()->approved()->get());
    }
}
