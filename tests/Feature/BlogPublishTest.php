<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogPublishTest extends TestCase
{
    use RefreshDatabase;
    
    public function setup() : void
    {
        parent::setup();
        $this->createAuthUser();
    }
   /** @test */
    public function userPublishBlog()
    {
        //prepare

        $blog = $this->createBlog(['user_id'=> auth()->id()]);
        //act
        $response = $this->patch(route('blog.show',$blog->slug), ['published_at' =>now()]);
        //assertion
      

        $response->assertRedirect('/blog');
        $this->assertNotNull($blog->fresh()->published_at);
    }
    /** @test */
    public function userUnpublishBlog()
    {
        //prepare
       
        $blog = $this->createBlog(['published_at' => now(), 'user_id'=> auth()->id()]);

    
        //act
        $response = $this->patch(route('blog.show',$blog->slug), ['published_at' =>null]);
        //assertion
      

        $response->assertRedirect('/blog');
        $this->assertNull($blog->fresh()->published_at);
    }
}
