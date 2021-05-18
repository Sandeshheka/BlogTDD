<?php

namespace Tests\Feature;

use App\Blo;
use App\Blog;
use App\User;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BloTest extends TestCase
{
    use RefreshDatabase;
 

    public function setup() : void
    {
        parent::setup();
        $this->createAuthUser();
    }
 
    /** @test */
    public function testBlog()
    {        //past
        $blog = $this->createBlog(['published_at' => now()],2);
        $unPublishedBlog = $this->createBlog();
        // $blog1 = $this->createBlog(['title'=> 'k garne ho']);
        //present & action
        
        $response = $this->get(route('blog.index'));

        //future/assertion
        $response->assertStatus(200);
        $response->assertSee($blog[0]->title);
        $response->assertSee($blog[1]->title);
        $response->assertDontSee($unPublishedBlog->title);
    }
     
    /** @test */
    public function allUserBlog()
    {        //past
        $blog = $this->createBlog(['published_at' => now(),'user_id' => auth()->id()],2);
        $unPubBlog = $this->createBlog(['user_id' => auth()->id()],2);
        $user2Blog = $this->createBlog(['user_id' => 22]);


        //present & action
        
        $response = $this->get(route('blog.all'));

        //future/assertion
        $response->assertStatus(200);
        $response->assertSee($blog[0]->title);
        $response->assertSee($blog[1]->title);
        $response->assertSee($unPubBlog[0]->title);
        $response->assertSee($unPubBlog[1]->title);
        $response->assertDontSee($user2Blog->title);

    }

        /** @test */
        public function userUnpublishedBlog()
        {        //past
            $this->withExceptionHandling();
            $blog = $this->createBlog();

            //present & action
            
            $response = $this->get(route('blog.show',$blog->slug) );
    
            //future/assertion
            $response->assertStatus(404);
            $response->assertDontSee($blog->title);
           
        }

    /** @test */
    public function single_blog_show()
    {
        $user = $this->createuser();
        $blog = $this->createBlog(['published_at' => now(), 'user_id' => $user->id]);

        $tag =  $this->createTag();
        $blog->tags()->attach($tag->id);
   
        $response = $this->get(route('blog.show',$blog->slug) );


        $response->assertStatus(200);
        $response->assertSee($blog->title);
        $response->assertSee($blog->body);
        $response->assertSee($blog->user->name);
        $response->assertSee($blog->tags[0]->name);
    }
    /** @test */
    public function user_can_store_a_blog()
    {
        //prepare

        $blog = Factory(Blog::class)->raw();
        $tags = $this->createTag([], 2);
        
        //act
        unset($blog['user_id']);
        $data = array_merge(['tag_ids' => $tags->pluck('id')->toArray()],
                $blog);    

        $response =$this->post(route('blog.store'),$data);
        //assertion
        $response->assertRedirect(route('blog.index'));
        
        $this->assertDatabaseHas('blogs', 
            ['image' =>$blog['image']->name,
            'user_id' => auth()->id()
        ]);
        $this->assertDatabaseHas('blog_tag', [
             'tag_id' => $tags[0]->id   
            ]);
    }


    /** @test */
    public function delete_a_blog()
    {
        //prepare
  
        $blog = $this->createBlog(['user_id'=> auth()->id()]);
        $tag = $this->createTag();
        $blog->tags()->attach($tag->id);
        //act
            $res = $this->delete(route('blog.destroy',$blog->slug));
        //assertion
            $res->assertRedirect(route('blog.index'));
            $this->assertDatabaseMissing('blogs', ['title'=> $blog->title]);
            $this->assertDatabaseMissing('blog_tag', ['blog_id'=> $blog->id]);
    }

    /** @test */
    public function user_can_update_blog_details()
    {
        //prepare
    
        $blog = $this->createBlog(['user_id'=> auth()->id()]);
        $tags = $this->createTag([],2);
        $blog->tags()->attach($tags->pluck('id'));
        //act
        $res = $this->patch(route('blog.update',$blog->slug),
            ['title'=> 'updated Id',
              'tag_ids' => $tags[0]->id  
            ]);
        //assertion
        $res->assertRedirect(route('blog.index'));
        $this->assertDatabaseHas('blogs', ['id'=>$blog->id,'title'=> 'updated Id']);
        $this->assertDatabaseMissing('blog_tag', [
            'blog_id'=> $blog->id,
            'tag_id' => $tags[1]->id]);
    }

    
/** @test */
    public function visitBlogForm()
    {
        //prepare
     
        //act
        $res = $this->get(route('blog.create'));

        //assertion
        $res->assertStatus(200);
        $res->assertSee('Create New Blog');
    }

    /** @test */    
    public function userVisitBlogForm()
    {
        //prepare
   
        $blog = $this->createBlog();

        //act
        $res = $this->get(route('blog.edit', $blog->slug) );
        //assertion
        $res->assertStatus(200);
        $res->assertSee('Update the blog');    
        $res->assertSee($blog->title);


    }
}
