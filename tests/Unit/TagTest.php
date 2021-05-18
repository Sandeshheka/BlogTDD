<?php

namespace Tests\Unit;

use App\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{

    use RefreshDatabase;
        /**
        @test
     */
    public function TagBlogTest()
    {
        //prepare
        $blog = $this->createBlog();
        $tag = $this->createTag();
           
         $tag->blogs()->attach($blog->id);
        //act
       
        //assertion
        $this->assertInstanceOf( Blog::class, $tag->blogs->first() );
    }
}
