<?php

namespace Dealskoo\Comment\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Comment\Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('comments.index'));
        $this->assertNotNull(PermissionManager::getPermission('comments.show'));
        $this->assertNotNull(PermissionManager::getPermission('comments.edit'));
        $this->assertNotNull(PermissionManager::getPermission('comments.destroy'));
    }
}
