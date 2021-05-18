<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogAuthTest extends TestCase
{
    use RefreshDatabase;
    /**
    @test
     */
    public function userRoleBlog()
    {
      //prepare
        $this->withExceptionHandling();
      $user = $this->createAuthUser();
        $blog = $this->createBlog();
      //act
        $res =$this->patch(route('blog.update', $blog->slug));
      //assert
        $res->assertStatus(403);

    }
        /**
    @test
     */
    public function userDeleteRoleBlog()
    {
      //prepare
        $this->withExceptionHandling();
      $user = $this->createAuthUser();
        $blog = $this->createBlog();
      //act
        $res =$this->delete(route('blog.destroy', $blog->slug));
      //assert
        $res->assertStatus(403);

    }
}
