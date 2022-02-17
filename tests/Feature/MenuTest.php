<?php

namespace Dealskoo\Comment\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Comment\Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $this->assertNotNull(AdminMenu::findBy('title', 'comment::comment.comments'));
    }
}
