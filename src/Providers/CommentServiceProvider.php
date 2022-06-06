<?php

namespace Dealskoo\Comment\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/comment.php', 'comment');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../config/comment.php' => config_path('comment.php')
            ], 'config');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/comment')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'comment');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'comment');

        AdminMenu::route('admin.comments.index', 'comment::comment.comments', [], ['icon' => 'uil-comment', 'permission' => 'comments.index'])->order(9);

        PermissionManager::add(new Permission('comments.index', 'Comment List'));
        PermissionManager::add(new Permission('comments.show', 'View Comment'), 'comments.index');
        PermissionManager::add(new Permission('comments.edit', 'Edit Comment'), 'comments.index');
        PermissionManager::add(new Permission('comments.destroy', 'Destroy Comment'), 'comments.index');
    }
}
