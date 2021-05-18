<?php

namespace Tests\Unit;

use App\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
      @test
     */
    public function userManyBlogs()
    {
        //prepare
        $user = $this->createUser();
        $blog = $this->createBlog(['user_id' => $user->id]);
        

        //assert
        $this->assertInstanceOf(Blog::class, $user->blogs[0]);
       
    }
}
