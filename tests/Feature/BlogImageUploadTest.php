<?php

namespace Tests\Feature;

use App\Blog;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogImageUploadTest extends TestCase
{
    use RefreshDatabase;

    /**
        @test
     */
    public function imageUploadBlog()
    {
       //prepare
       Storage::fake();
      
        $this->createAuthUser();
       
       $blog = Factory(Blog::class)->raw();


       //act
       
       $response =$this->post(route('blog.store'),$blog);
       //assertion
       
       
       $this->assertDatabaseHas('blogs', ['image' => $blog['image']->name] );
       Storage::disk('public')->assertExists('photo1.jpg');
    }
        /**
        @test
     */
    public function imageUpdteImageBlog()
    {
       //prepare
       Storage::fake();
       $this->createAuthUser();
       $blog = $this->createBlog(['image' => 'photo1.jpg','user_id'=> auth()->id()]);
       $newImage = UploadedFile::fake()->image('photo2.jpg');

       //act
       
       $response =$this->patch(route('blog.update', $blog->slug), ['image' => $newImage]);
       //assertion
       
       
       $this->assertDatabaseHas('blogs', ['image' => $newImage->name] );
       Storage::disk('public')->assertExists('photo2.jpg');
       Storage::disk('public')->assertMissing('photo1.jpg');
    }

            /**
        @test
     */
    public function imageDeleteBlog()
    {
       //prepare
       Storage::fake();
       $this->createAuthUser();
       $blog = $this->createBlog(['user_id'=> auth()->id()]);
       Storage::disk('public')->put('photo1.jpg', file_get_contents($blog->image));
       $blog->update(['image' => 'photo1.jpg']);
       Storage::disk('public')->assertExists('photo1.jpg');

       //act
       
       $response =$this->delete(route('blog.destroy', $blog->slug));
       //assertion
       
       
       $this->assertDatabaseMissing('blogs', ['id' => $blog->id] );

       Storage::disk('public')->assertMissing('photo1.jpg');
    }
}
