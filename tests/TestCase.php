<?php

namespace Tests;

use App\Blog;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setup():void
    {
        parent::setUp();
        
        $this->withoutExceptionHandling();

    }
    protected function createBlog($args = [], $num = null)
    {
        return Factory(Blog::class, $num)->create($args);
    
    }
    protected function createTag($args = [], $num = null)
    {
        return Factory(Tag::class, $num)->create($args);
    
    }
    protected function createUser($args = [], $num = null)
    {
        return Factory(User::class, $num)->create($args);
    
    }

    protected function createAuthUser($args =[])
    {
        $user =$this->createUser();
        $this->actingAs($user);
        return $user;
    }
}
