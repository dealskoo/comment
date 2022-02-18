<?php

namespace Dealskoo\Comment\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Comment\Events\CommentCreated;
use Dealskoo\Comment\Events\CommentDeleted;
use Dealskoo\Comment\Events\CommentUpdated;
use Dealskoo\Comment\Models\Comment;
use Dealskoo\Comment\Tests\Post;
use Dealskoo\Comment\Tests\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Comment\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.comments.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.comments.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $comment = $user->comments()->first();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.comments.edit', $comment));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        Event::fake();
        $admin = Admin::factory()->isOwner()->create();
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        Event::assertDispatched(CommentCreated::class);
        $comment = $user->comments()->first();
        $comment1 = Comment::factory()->make();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.comments.update', $comment), $comment1->only([
            'score',
            'comment',
            'approved',
        ]));
        $response->assertStatus(302);
        Event::assertDispatched(CommentUpdated::class);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $comment = $user->comments()->first();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.comments.show', $comment));
        $response->assertStatus(200);
    }

    public function test_destroy()
    {
        Event::fake();
        $admin = Admin::factory()->isOwner()->create();
        $post = Post::create(['title' => 'post']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($post, $comment->comment, $comment->score);
        $comment = $user->comments()->first();
        $response = $this->actingAs($admin, 'admin')->delete(route('admin.comments.destroy', $comment));
        $response->assertStatus(200);
        $this->assertSoftDeleted($comment);
        Event::assertDispatched(CommentDeleted::class);
    }
}
