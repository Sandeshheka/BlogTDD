<?php

namespace Tests\Unit;

use App\Blog;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;
    /**
        @test
     */
    public function blogUploadImage()
    {
        //prepare
        $blog = new Blog();
        $image = UploadedFile::fake()->image('photo1.jpg');
        //act
        $blog->uploadImage($image);
        //assertion
        Storage::disk('public')->assertExists('photo1.jpg');
    }

    /**
        @test
     */
    public function blogBelongsUser()
    {
        //prepare
        $user = $this->createUser();
         $blog = $this->createBlog(['user_id'=> $user->id]);   
        //act
       
        //assertion
        $this->assertInstanceOf( User::class, $blog->user );
    }

        /**
        @test
     */
    public function blogTagTest()
    {
        //prepare
        $tag = $this->createTag();
         $blog = $this->createBlog();   
         $blog->tags()->attach($tag->id);
        //act
       
        //assertion
        $this->assertInstanceOf( Tag::class, $blog->tags[0] );
    }

    /**
     * @test
     */

     public function blogTagViewTest()
     {
         //prepare
            $blog = $this->createBlog();
            $tags = $this->createTag([], 4);
            $blog->tags()->attach($tags->pluck('id'));
         //assert
            $this->assertIsArray($blog->tagIds());
            $this->assertEquals(4, count($blog->tagIds()));
            $this->assertEquals($tags[3]->id, $blog->tagIds()[3]);
            // $this->assertArrayHasKey($tags[0]->id, $blog->tagIds());
     }

     public function blogPublishedField()
     {
         $time = now();
         $blog =$this->createBlog(['published_at' => now()]);
         $this->assertEquals($time->format('Y-m-d\TH:m'), $blog->published_at);

     }

    
}
