<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\User;
use App\Comment;
use App\Role;
use Faker\Factory;

class DashboardViewsTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testDashboardView()
    {
        $admin = factory(User::class)->create();
        $role_admin = factory(Role::class)->states('admin')->create();
        $admin->roles()->attach($role_admin);

        $posts = factory(Post::class, 30)->create();
        $comment = factory(Comment::class)->create();
        $users = factory(User::class, 5)->create();

        $this->actingAs($admin)
            ->visit(route('admin.dashboard'))
            ->see(__('dashboard.this_week'))
            ->see(Post::count())
            ->see($comment->count())
            ->see(trans_choice('comments.new_comments', $comment->count()))
            ->see(User::count());
    }
}
