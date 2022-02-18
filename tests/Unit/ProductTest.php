<?php

namespace Dealskoo\Comment\Tests\Unit;

use Dealskoo\Comment\Models\Comment;
use Dealskoo\Comment\Tests\Product;
use Dealskoo\Comment\Tests\TestCase;
use Dealskoo\Comment\Tests\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_comments()
    {
        $product = Product::create(['name' => 'product']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($product, $comment->comment, $comment->score);
        $this->assertCount(1, $product->comments()->get());
    }

    public function test_approved_comments()
    {
        $product = Product::create(['name' => 'product']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $user->comment($product, $comment->comment, $comment->score);
        $this->assertCount(1, $product->approvedComments()->get());
    }

    public function test_comment()
    {
        $product = Product::create(['name' => 'product']);
        $user = User::create(['name' => 'user']);
        $comment = Comment::factory()->make();
        $product->comment($user, $comment->comment, $comment->score);
        $this->assertCount(1, $product->comments()->get());
    }
}
